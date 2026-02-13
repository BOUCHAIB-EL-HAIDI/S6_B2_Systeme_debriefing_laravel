<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Brief;
use App\Models\Sprint;
use App\Models\Competence;
use App\Models\Classe;
use App\Models\User;
use App\Models\Debriefing;
use App\Models\Livrable;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacher = Auth::user();
        $classes = $teacher->classes()->withCount('students')->get();
        $briefs = $teacher->briefs()->latest()->take(5)->get();

        $classIds = $classes->pluck('id');
        $students = User::students()
            ->whereIn('classe_id', $classIds)
            ->with(['classe'])
            ->get();

        // 1. Fetch latest started briefs for each class in bulk
        // We fetch all briefs related to these classes and filter in memory to find the latest per class
        $allRelatedBriefs = Brief::whereHas('sprint.classes', function($q) use ($classIds) {
                $q->whereIn('classes.id', $classIds);
            })
            ->where('start_date', '<=', now())
            ->with('sprint.classes') // To group by class later
            ->orderBy('start_date', 'desc')
            ->get();

        $latestBriefsByClass = [];
        foreach ($classIds as $classId) {
            $latestBriefsByClass[$classId] = $allRelatedBriefs->first(function($b) use ($classId) {
                return $b->sprint->classes->contains($classId);
            });
        }

        $relevantBriefIds = collect($latestBriefsByClass)->pluck('id')->filter()->unique();
        $studentIds = $students->pluck('id');

        // 2. Fetch all livrables for these students and these specific briefs in bulk
        $allLivrables = Livrable::whereIn('student_id', $studentIds)
            ->whereIn('brief_id', $relevantBriefIds)
            ->latest('submitted_at')
            ->get()
            ->groupBy(function($l) {
                return $l->student_id . '_' . $l->brief_id;
            });

        // 3. Fetch all debriefings for these students and these specific briefs in bulk
        $allDebriefings = Debriefing::whereIn('student_id', $studentIds)
            ->whereIn('brief_id', $relevantBriefIds)
            ->get()
            ->keyBy(function($d) {
                return $d->student_id . '_' . $d->brief_id;
            });

        // Map students to their status
        $deliverablesTracking = $students->map(function($student) use ($latestBriefsByClass, $allLivrables, $allDebriefings) {
            $latestBrief = $latestBriefsByClass[$student->classe_id] ?? null;
            $key = $student->id . '_' . ($latestBrief ? $latestBrief->id : 0);
            
            $studentBriefLivrables = $allLivrables->get($key) ?? collect();
            $status = 'PAS_DE_BRIEF';
            
            if ($latestBrief) {
                if ($studentBriefLivrables->isNotEmpty()) {
                    $status = 'RENDU';
                } elseif ($latestBrief->end_date && $latestBrief->end_date->endOfDay() < now()) {
                    $status = 'INVALIDE'; // Deadline passed and no work submitted
                } else {
                    $status = 'EN_ATTENTE'; // Deadline not passed yet
                }
            }
            
            return (object)[
                'student' => $student,
                'livrable' => $studentBriefLivrables->first(),
                'livrables_count' => $studentBriefLivrables->count(),
                'status' => $status,
                'is_evaluated' => $allDebriefings->has($key),
                'brief' => $latestBrief
            ];
        });

        $stats = [
            'briefs_count' => $teacher->briefs()->count(),
            'classes_count' => $classes->count(),
        ];
        return view('teacher.dashboard', compact('stats', 'classes', 'briefs', 'deliverablesTracking'));
    }

    public function studentLivrables($id)
    {
        $student = User::with('classe')->findOrFail($id);
        
        // Get all briefs assigned to the student's class via sprints
        $totalBriefs = Brief::whereHas('sprint', function($q) use ($student) {
            $q->whereHas('classes', function($q2) use ($student) {
                $q2->where('classes.id', $student->classe_id);
            });
        })->count();

        $submittedBriefs = Livrable::where('student_id', $id)
            ->distinct('brief_id')
            ->count('brief_id');

        $submissionRate = $totalBriefs > 0 ? round(($submittedBriefs / $totalBriefs) * 100) : 0;

        $livrables = Livrable::where('student_id', $id)
            ->with('brief.sprint')
            ->orderBy('submitted_at', 'desc')
            ->get();
            
        $briefIds = $livrables->pluck('brief_id')->unique();
        $evaluatedBriefIds = Debriefing::where('student_id', $id)
            ->whereIn('brief_id', $briefIds)
            ->pluck('brief_id')
            ->toArray();

        $livrables->each(function($l) use ($evaluatedBriefIds) {
            $l->is_evaluated = in_array($l->brief_id, $evaluatedBriefIds);
        });
            
        return view('teacher.student_livrables', compact('student', 'livrables', 'submissionRate', 'totalBriefs', 'submittedBriefs'));
    }

    public function index()
    {
        $briefs = Auth::user()->briefs()->with('sprint')->latest()->paginate(10);
        return view('teacher.briefs', compact('briefs'));
    }

    public function create()
    {
        $teacher = Auth::user();
        // Get sprints associated with teacher's classes
        $sprints = Sprint::whereHas('classes', function($query) use ($teacher) {
            $query->whereIn('classes.id', $teacher->classes->pluck('id'));
        })->get();

        $competences = Competence::all();
        return view('teacher.createbrief', compact('sprints', 'competences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:INDIVIDUAL,COLLECTIVE',
            'sprint_id' => 'required|exists:sprints,id',
            'competences' => 'required|array',
            'competences.*' => 'exists:competences,code',
        ]);

        $brief = Auth::user()->briefs()->create($validated);
        $brief->competences()->attach($request->competences);

        return redirect()->route('teacher.briefs')->with('success', 'Brief créé avec succès !');
    }

    public function show($id)
    {
        $brief = Brief::with(['sprint', 'competences'])->findOrFail($id);
        $deliverables = Livrable::where('brief_id', $id)
            ->with('student')
            ->latest('submitted_at')
            ->get();

        // Check evaluation status for each student-brief pair
        foreach ($deliverables as $del) {
            $del->is_evaluated = Debriefing::where('student_id', $del->student_id)
                ->where('brief_id', $del->brief_id)
                ->exists();
        }
            
        // Calculate Global Submission Rate
        $sprintId = $brief->sprint_id;
        $totalStudents = User::students()
            ->whereHas('classe', function($q) use ($sprintId) {
                $q->whereHas('sprints', function($q2) use ($sprintId) {
                    $q2->where('sprints.id', $sprintId);
                });
            })->count();

        $submittedCount = Livrable::where('brief_id', $id)
            ->distinct('student_id')
            ->count('student_id');

        $submissionRate = $totalStudents > 0 ? round(($submittedCount / $totalStudents) * 100) : 0;

        return view('teacher.brief_details', compact('brief', 'deliverables', 'submissionRate', 'totalStudents', 'submittedCount'));
    }

    public function edit($id)
    {
        $brief = Auth::user()->briefs()->with('competences')->findOrFail($id);
        $teacher = Auth::user();

        $sprints = Sprint::whereHas('classes', function($query) use ($teacher) {
            $query->whereIn('classes.id', $teacher->classes->pluck('id'));
        })->get();

        $competences = Competence::all();

        return view('teacher.editbrief', compact('brief', 'sprints', 'competences'));
    }

    public function update(Request $request, $id)
    {
        $brief = Auth::user()->briefs()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:INDIVIDUAL,COLLECTIVE',
            'sprint_id' => 'required|exists:sprints,id',
            'competences' => 'required|array',
            'competences.*' => 'exists:competences,code',
        ]);

        $brief->update($validated);
        $brief->competences()->sync($request->competences);

        return redirect()->route('teacher.briefs')->with('success', 'Brief mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $brief = Auth::user()->briefs()->findOrFail($id);
        $brief->delete();

        return redirect()->route('teacher.briefs')->with('success', 'Brief supprimé avec succès !');
    }

    public function debriefing(Request $request)
    {
        $teacher = Auth::user();
        $briefs = $teacher->briefs()->latest()->get();

        // Fetch students from classes taught by the teacher
        $students = User::students()
            ->with('classe')
            ->whereIn('classe_id', $teacher->classes->pluck('id'))
            ->orderBy('last_name')
            ->get();

        $selectedStudentId = $request->query('student');
        $selectedBriefId = $request->query('brief');

        return view('teacher.debriefing', compact('briefs', 'students', 'selectedStudentId', 'selectedBriefId'));
    }

    public function getDebriefingData(Request $request)
    {
        $request->validate([
            'brief_id' => 'required|exists:briefs,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $debriefing = Debriefing::with('competences')
            ->where('brief_id', $request->brief_id)
            ->where('student_id', $request->student_id)
            ->first();

        if (!$debriefing) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'comment' => $debriefing->comment,
            'evaluations' => $debriefing->competences->mapWithKeys(function($comp) {
                return [$comp->code => [
                    'niveau' => $comp->pivot->niveau,
                    'status' => $comp->pivot->status,
                ]];
            })
        ]);
    }

    public function getBriefCompetences($id)
    {
        $brief = Brief::with('competences')->findOrFail($id);
        return response()->json($brief->competences);
    }

    public function storeDebriefing(Request $request)
    {
        $request->validate([
            'brief_id' => 'required|exists:briefs,id',
            'student_id' => 'required|exists:users,id',
            'comment' => 'nullable|string',
            'evaluations' => 'required|array',
            'evaluations.*.niveau' => 'required|in:NIVEAU_1,NIVEAU_2,NIVEAU_3',
            'evaluations.*.status' => 'required|in:VALIDEE,INVALIDE',
        ]);

        // Check if student has submitted a livrable
        $hasLivrable = Livrable::where('brief_id', $request->brief_id)
            ->where('student_id', $request->student_id)
            ->exists();

        if (!$hasLivrable) {
            return redirect()->back()->with('error', 'L\'étudiant doit soumettre un livrable avant d\'être évalué.');
        }

        // Check if debriefing already exists
        $exists = Debriefing::where('brief_id', $request->brief_id)
            ->where('student_id', $request->student_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Cet étudiant a déjà été évalué pour ce brief. L\'évaluation ne peut pas être modifiée.');
        }

        // Create debriefing
        $debriefing = Debriefing::create([
            'brief_id' => $request->brief_id,
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        // Sync competences with pivot data
        $syncData = [];
        foreach ($request->evaluations as $code => $eval) {
            $syncData[$code] = [
                'niveau' => $eval['niveau'],
                'status' => $eval['status']
            ];
        }

        $debriefing->competences()->sync($syncData);

        return redirect()->back()->with('success', 'Débriefing enregistré avec succès !');
    }

    public function checkLivrable($brief_id, $student_id)
    {
        $livrables = Livrable::where('brief_id', $brief_id)
            ->where('student_id', $student_id)
            ->latest('submitted_at')
            ->get();

        return response()->json([
            'submitted' => $livrables->isNotEmpty(),
            'count' => $livrables->count(),
            'deliveries' => $livrables
        ]);
    }

    public function progression()
    {
        $teacher = Auth::user();
        $classIds = $teacher->classes->pluck('id');
        $students = User::students()
            ->whereIn('classe_id', $classIds)
            ->with('classe')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('teacher.progression', compact('students'));
    }

    public function getStudentProgressionData($id)
    {
        $debriefings = Debriefing::where('student_id', $id)
            ->with(['brief', 'teacher', 'competences'])
            ->latest('id') // using id since created_at might be non-standard
            ->get();

        $data = $debriefings->map(function($d) {
            $date = $d->created_at instanceof \Carbon\Carbon 
                ? $d->created_at 
                : \Carbon\Carbon::parse($d->created_at);

            return [
                'brief_title' => $d->brief ? $d->brief->title : 'N/A',
                'date' => $date->format('Y-m-d'),
                'teacher_name' => $d->teacher 
                    ? ($d->teacher->first_name . ' ' . $d->teacher->last_name) 
                    : 'Anonyme',
                'comment' => $d->comment,
                'competences' => $d->competences->map(function($c) {
                    return [
                        'code' => $c->code,
                        'label' => $c->label,
                        'status' => $c->pivot->status,
                        'niveau' => $c->pivot->niveau
                    ];
                })
            ];
        });

        return response()->json($data);
    }
}
