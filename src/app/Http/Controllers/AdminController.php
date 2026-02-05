<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showDashboard(){

    return view('admin.dashboard');
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
