<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classe;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     public function showUsers(){



    $users = User::with('classe')
    ->where('role', '!=', 'ADMIN')
    ->paginate(6);

     return view('admin.users.showusers' , compact('users'));

     }
     public function create(){

        $usedClassIds = User::Teachers()->whereNotNull('classe_id')->pluck('classe_id');
        $unassignedClasses = Classe::whereNotIn('id' , $usedClassIds)->get();
        $allClasses =Classe::all();
        return view('admin.users.create' , compact('unassignedClasses' ,'allClasses' ));
     }

     public function store(Request $request){

     $validated = $request->validate([

        'first_name' =>'required|string|max:30',
        'last_name' =>'required|string|max:30',
        'email' =>'required|email|unique:users,email',
        'password'=>'required|min:6',
        'role' =>'required|in:TEACHER,ADMIN,STUDENT',

        'classe_id' =>'required_if:role,STUDENT,TEACHER|nullable|exists:classes,id',

        //only for teachers

        'backup_classes' =>'nullable|array',
        'backup_classes.*' =>'exists:classes,id',

     ]);

     $user = User::create([

            'first_name' =>$validated['first_name'],
            'last_name' =>$validated['last_name'],
            'email' =>$validated['email'],
            'password' =>bcrypt($validated['password']),
            'role' =>$validated['role'],
            'classe_id' =>$validated['classe_id'] ?? null,
     ]);

     if($user->isTeacher()){


     $backupClasses = $validated['backup_classes'] ?? [];

     if($user->classe_id  && !in_array($user->classe_id , $backupClasses)){

     $backupClasses[] = $user->classe_id;
     }

     $user->classes()->sync($backupClasses);

     }
     return redirect('/admin/users')->with('success' , 'Utilisateur cree avec succés !');


     }


     public function edit($id)
     {

      $usedClassIds = User::Teachers()->whereNotNull('classe_id')->pluck('classe_id');
      $unassignedClasses = Classe::whereNotIn('id' , $usedClassIds)->get();
      $allClasses =Classe::all();

      $user = User::findOrFail($id);
      return view('admin.users.edit', compact('user','unassignedClasses','allClasses' ) );

     }

     public function update(Request $request , $id)
      {
        $validated = $request->validate([

        'first_name' =>'required|string|max:30',
        'last_name' =>'required|string|max:30',
        'email' =>'required|email|unique:users,email,' . $id,
        'password'=>'required|min:6',


     ]);


      $user = User::findOrFail($id);

      $user->first_name = $validated['first_name'];
      $user->last_name = $validated['last_name'];
      $user->email = $validated['email'];
      $user->password = Hash::make($validated['password']);

     $user->save();

     return redirect()->route('admin.users.showusers')
                     ->with('success', 'Utilisateur mis à jour avec succès.');
      }

      public function destroy($id)
     {
       $user = User::findOrFail($id);
      if($user->isTeacher()){
       $user->classes()->detach();
      }
      $user->delete();

       return redirect()->route('admin.users.showusers')->with('success', 'Utilisateur supprimé avec succès');
     }



}
