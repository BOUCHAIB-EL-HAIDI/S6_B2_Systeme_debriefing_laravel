<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SprintsController;
use App\Http\Controllers\CompetenceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login' ,[AuthController::class , 'showLogin'] )->name('login');
Route::post('/login' , [AuthController::class , 'submitLogin'])->name('auth.submitLogin');
Route::get('/admin/dashboard' ,[AdminController::class , 'showDashboard'] )->name('admin.dashboard');
// Route::get('/admin/users' ,[AdminController::class , 'showUsers'] )->name('admin.users');
// Route::get('/admin/users/create' ,[AdminController::class , 'createUser'] )->name('admin.createuser');

// Class CRUD Routes
Route::get('/admin/classes', [ClasseController::class, 'index'])->name('admin.classes.index');
Route::get('/admin/classes/create', [ClasseController::class, 'create'])->name('admin.classes.create');
Route::post('/admin/classes', [ClasseController::class, 'store'])->name('admin.classes.store');
Route::get('/admin/classes/{id}/edit', [ClasseController::class, 'edit'])->name('admin.classes.edit');
Route::put('/admin/classes/{id}', [ClasseController::class, 'update'])->name('admin.classes.update');
Route::delete('/admin/classes/{id}', [ClasseController::class, 'destroy'])->name('admin.classes.destroy');


//user routes
Route::get('/admin/users', [UserController::class, 'showUsers'])->name('admin.users.showusers');
Route::get('/admin/users/create' ,[UserController::class , 'create'] )->name('admin.users.create');
Route::post('/admin/users/create', [UserController::class, 'store'])->name('admin.users.store');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');


//sprints routes

Route::get('/admin/sprints', [SprintsController::class, 'showAndCreate'])->name('admin.sprints.showandcreate');
Route::post('/admin/sprints', [SprintsController::class, 'store'])->name('admin.sprints.store');

// Competence CRUD Routes
Route::get('/admin/competences', [CompetenceController::class, 'index'])->name('admin.competences.index');
Route::get('/admin/competences/create', [CompetenceController::class, 'create'])->name('admin.competences.create');
Route::post('/admin/competences', [CompetenceController::class, 'store'])->name('admin.competences.store');
Route::get('/admin/competences/{code}/edit', [CompetenceController::class, 'edit'])->name('admin.competences.edit');
Route::put('/admin/competences/{code}', [CompetenceController::class, 'update'])->name('admin.competences.update');
Route::delete('/admin/competences/{code}', [CompetenceController::class, 'destroy'])->name('admin.competences.destroy');

