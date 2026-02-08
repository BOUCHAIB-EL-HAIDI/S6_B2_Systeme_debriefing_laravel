<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use App\Models\Sprint;
use App\Models\Competence;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $stats = [
            'students_count' => User::where('role', 'STUDENT')->count(),
            'teachers_count' => User::where('role', 'TEACHER')->count(),
            'classes_count' => Classe::count(),
            'sprints_count' => Sprint::count(),
            'competences_count' => Competence::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

//    public function showUsers(){
//     return view('admin.users');

//    }
   public function createUser(){
    return view('admin.createuser');

   }
    // public function showClasses(){
    // return view('admin.classes');
    // }

}
