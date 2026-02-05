<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::all();
        return view('admin.classes', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        Classe::create($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Classe créée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $classe = Classe::findOrFail($id);
        return view('admin.classes.edit', compact('classe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $classe = Classe::findOrFail($id);
        $classe->update($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Classe mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Classe supprimée avec succès.');
    }
}
