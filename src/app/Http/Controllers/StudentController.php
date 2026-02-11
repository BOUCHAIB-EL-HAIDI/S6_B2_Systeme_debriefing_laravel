<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brief;
use App\Models\Livrable;
use App\Models\Debriefing;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user();
        $classe = $student->classe;
        
        // Get all briefs assigned to the student's class (via sprints)
        $briefs = Brief::whereHas('sprint.classes', function($query) use ($classe) {
            $query->where('classes.id', $classe->id);
        })->latest()->take(3)->get();

        $stats = [
            'total_briefs' => Brief::whereHas('sprint.classes', function($query) use ($classe) {
                $query->where('classes.id', $classe->id);
            })->count(),
            'submitted_livrables' => $student->livrables()->count(),
            'validated_competences' => Debriefing::where('student_id', $student->id)
                ->with('competences')
                ->get()
                ->pluck('competences')
                ->flatten()
                ->where('pivot.status', 'VALIDEE')
                ->unique('code')
                ->count(),
        ];

        return view('student.dashboard', compact('briefs', 'stats', 'classe'));
    }

    public function briefs()
    {
        $student = Auth::user();
        $classe = $student->classe;

        $briefs = Brief::whereHas('sprint.classes', function($query) use ($classe) {
            $query->where('classes.id', $classe->id);
        })->with('sprint')->latest()->paginate(10);

        return view('student.briefs', compact('briefs'));
    }

    public function showBrief($id)
    {
        $student = Auth::user();
        $brief = Brief::with(['competences', 'sprint'])->findOrFail($id);
        
        $livrables = Livrable::where('brief_id', $id)
            ->where('student_id', $student->id)
            ->latest('submitted_at')
            ->get();

        return view('student.brief_details', compact('brief', 'livrables'));
    }

    public function storeLivrable(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|url',
            'comment' => 'nullable|string|max:500',
        ]);

        $student = Auth::user();

        Livrable::create([
            'brief_id' => $id,
            'student_id' => $student->id,
            'content' => $request->content,
            'comment' => $request->comment,
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Votre travail a été soumis avec succès !');
    }

    public function progression()
    {
        $student = Auth::user();
        
        // Get all debriefings for this student with their competences
        $debriefings = Debriefing::with(['competences', 'brief'])
            ->where('student_id', $student->id)
            ->latest()
            ->get();

        return view('student.progression', compact('debriefings'));
    }
}
