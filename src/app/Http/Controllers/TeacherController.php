<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        return view('teacher.dashboard');
    }

    public function briefs()
    {
        return view('teacher.briefs');
    }

    public function createBrief()
    {
        return view('teacher.createbrief');
    }

    public function briefDetails($id)
    {
        return view('teacher.brief_details');
    }

    public function debriefing()
    {
        return view('teacher.debriefing');
    }

    public function progression()
    {
        return view('teacher.progression');
    }
}
