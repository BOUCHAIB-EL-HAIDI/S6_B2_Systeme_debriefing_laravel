<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

public function showLogin()
{
 return view('auth.login');
}

public function submitLogin(Request $request){

$request->validate([

'email'=>'required|email',
 'password'=>'required'
]);

$credentials = $request->only('email','password');

if(Auth::attempt($credentials)){

$request->session()->regenerate();

if(Auth::user()->isAdmin()){

return redirect()->route('admin.dashboard');

}else if(Auth::user()->isTeacher()){

return redirect()->route('teacher.dashboard');
}else {
return redirect()->route('student.dashboard');
}

}

return back()->withErrors([
'email' =>'Email ou mot de passe incorrect'

])->onlyInput('email');


}

}
