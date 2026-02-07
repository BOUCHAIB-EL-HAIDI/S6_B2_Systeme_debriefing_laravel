<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SprintsController extends Controller
{
    public function show()
    {
      $sprints = Sprint::all();

     return view('admin.sprints.show' , compact('sprints'));

    }




}
