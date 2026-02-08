<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    public function index()
    {
        $competences = Competence::all();
        return view('admin.competences.index', compact('competences'));
    }

    public function create()
    {
        return view('admin.competences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'regex:/^C[0-9]+$/',
                'unique:competences,code'
            ],
            'label' => 'required|string|max:150',
        ], [
            'code.regex' => 'The code must start with "C" followed by one or more numbers (e.g., C1).',
            'code.unique' => 'This competence code already exists.',
        ]);

        Competence::create($validated);

        return redirect()->route('admin.competences.index')->with('success', 'Competence created successfully.');
    }

    public function edit($code)
    {
        $competence = Competence::findOrFail($code);
        return view('admin.competences.edit', compact('competence'));
    }

    public function update(Request $request, $code)
    {
        $competence = Competence::findOrFail($code);

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'regex:/^C[0-9]+$/',
                'unique:competences,code,' . $code . ',code'
            ],
            'label' => 'required|string|max:150',
        ], [
            'code.regex' => 'The code must start with "C" followed by one or more numbers (e.g., C1).',
            'code.unique' => 'This competence code already exists.',
        ]);

        $competence->update($validated);

        return redirect()->route('admin.competences.index')->with('success', 'Competence updated successfully.');
    }

    public function destroy($code)
    {
        $competence = Competence::findOrFail($code);
        $competence->delete();

        return redirect()->route('admin.competences.index')->with('success', 'Competence deleted successfully.');
    }
}
