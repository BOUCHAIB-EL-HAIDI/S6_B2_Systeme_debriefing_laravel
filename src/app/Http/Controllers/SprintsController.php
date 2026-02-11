<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use App\Models\Classe;

class SprintsController extends Controller
{
    public function showAndCreate()
    {
      $sprints = Sprint::all();

     return view('admin.sprints.showandcreate' , compact('sprints'));

    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5|string|unique:sprints,name',
            'duration' => 'required|integer|gt:0',
            'order' => 'required|integer|gt:0|unique:sprints,order',
        ]);

        $sprint = Sprint::create([
            'name' => $validated['name'],
            'duration' => $validated['duration'],
            'order' => $validated['order'],
        ]);

        // Auto-attach to all classes
        $classes = Classe::all();
        $sprint->classes()->attach($classes);

        return redirect()->route('admin.sprints.showandcreate')->with('success', 'Sprint was created successfully and assigned to all classes');
    }

    public function edit($id)
    {
        $sprint = Sprint::findOrFail($id);
        return view('admin.sprints.edit', compact('sprint'));
    }

    public function update(Request $request, $id)
    {
        $sprint = Sprint::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|min:5|string|unique:sprints,name,' . $id,
            'duration' => 'required|integer|gt:0',
            'order' => 'required|integer|gt:0|unique:sprints,order,' . $id,
        ]);

        $sprint->update($validated);

        return redirect()->route('admin.sprints.showandcreate')->with('success', 'Sprint updated successfully');
    }

    public function destroy($id)
    {
        $sprint = Sprint::findOrFail($id);
        $sprint->delete();

        return redirect()->route('admin.sprints.showandcreate')->with('success', 'Sprint deleted successfully');
    }



}
