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

        // Get recent deliverables from any student in any of the teacher's classes
        $recentDeliverables = Livrable::whereIn('student_id', function($query) use ($teacher) {
                $query->select('student_id')
                    ->from('classe_user') // Assuming a pivot table or relationship
                    ->whereIn('classe_id', $teacher->classes->pluck('id'));
            })
            // If the structure is simpler (e.g., student has classe_id)
            ->orWhereIn('student_id', User::whereIn('classe_id', $teacher->classes->pluck('id'))->pluck('id'))
            ->with(['student', 'brief'])
            ->latest('submitted_at')
            ->take(5)
            ->get();
        
        $stats = [
            'briefs_count' => $teacher->briefs()->count(),
            'classes_count' => $classes->count(),
        ];
        return view('teacher.dashboard', compact('stats', 'classes', 'briefs', 'recentDeliverables'));
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
            
        return view('teacher.brief_details', compact('brief', 'deliverables'));
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

    public function debriefing()
    {
        $teacher = Auth::user();
        $briefs = $teacher->briefs()->latest()->get();

        // Fetch students from classes taught by the teacher
        $students = User::students()
            ->with('classe')
            ->whereIn('classe_id', $teacher->classes->pluck('id'))
            ->orderBy('last_name')
            ->get();

        return view('teacher.debriefing', compact('briefs', 'students'));
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

        // Create or update debriefing
        $debriefing = Debriefing::updateOrCreate(
            [
                'brief_id' => $request->brief_id,
                'student_id' => $request->student_id,
            ],
            [
                'teacher_id' => Auth::id(),
                'comment' => $request->comment,
            ]
        );

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
        return view('teacher.progression');
    }
}
