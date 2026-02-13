<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SprintsController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

Route::get('/', [AuthController::class, 'showLogin'])->name('home');

Route::get('/login' ,[AuthController::class , 'showLogin'] )->name('login');
Route::post('/login' , [AuthController::class, 'submitLogin'])->name('auth.submitLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth', 'role:ADMIN'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');

    // Class CRUD Routes
    Route::get('/classes', [ClasseController::class, 'index'])->name('admin.classes.index');
    Route::get('/classes/create', [ClasseController::class, 'create'])->name('admin.classes.create');
    Route::post('/classes', [ClasseController::class, 'store'])->name('admin.classes.store');
    Route::get('/classes/{id}/edit', [ClasseController::class, 'edit'])->name('admin.classes.edit');
    Route::put('/classes/{id}', [ClasseController::class, 'update'])->name('admin.classes.update');
    Route::delete('/classes/{id}', [ClasseController::class, 'destroy'])->name('admin.classes.destroy');

    // User CRUD Routes
    Route::get('/users', [UserController::class, 'showUsers'])->name('admin.users.showusers');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Sprint CRUD Routes
    Route::get('/sprints', [SprintsController::class, 'showAndCreate'])->name('admin.sprints.showandcreate');
    Route::post('/sprints', [SprintsController::class, 'store'])->name('admin.sprints.store');
    Route::get('/sprints/{id}/edit', [SprintsController::class, 'edit'])->name('admin.sprints.edit');
    Route::put('/sprints/{id}', [SprintsController::class, 'update'])->name('admin.sprints.update');
    Route::delete('/sprints/{id}', [SprintsController::class, 'destroy'])->name('admin.sprints.destroy');

    // Competence CRUD Routes
    Route::get('/competences', [CompetenceController::class, 'index'])->name('admin.competences.index');
    Route::get('/competences/create', [CompetenceController::class, 'create'])->name('admin.competences.create');
    Route::post('/competences', [CompetenceController::class, 'store'])->name('admin.competences.store');
    Route::get('/competences/{code}/edit', [CompetenceController::class, 'edit'])->name('admin.competences.edit');
    Route::put('/competences/{code}', [CompetenceController::class, 'update'])->name('admin.competences.update');
    Route::delete('/competences/{code}', [CompetenceController::class, 'destroy'])->name('admin.competences.destroy');
});

Route::middleware(['auth', 'role:TEACHER'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    
    // Brief CRUD
    Route::get('/briefs', [TeacherController::class, 'index'])->name('teacher.briefs');
    Route::get('/briefs/create', [TeacherController::class, 'create'])->name('teacher.briefs.create');
    Route::post('/briefs', [TeacherController::class, 'store'])->name('teacher.briefs.store');
    Route::get('/briefs/{id}', [TeacherController::class, 'show'])->name('teacher.briefs.details');
    Route::get('/briefs/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.briefs.edit');
    Route::put('/briefs/{id}', [TeacherController::class, 'update'])->name('teacher.briefs.update');
    Route::delete('/briefs/{id}', [TeacherController::class, 'destroy'])->name('teacher.briefs.destroy');

    Route::get('/debriefing', [TeacherController::class, 'debriefing'])->name('teacher.debriefing');
    Route::get('/debriefing/data', [TeacherController::class, 'getDebriefingData'])->name('teacher.debriefing.data');
    Route::post('/debriefing', [TeacherController::class, 'storeDebriefing'])->name('teacher.debriefing.store');
    Route::get('/briefs/{id}/competences', [TeacherController::class, 'getBriefCompetences'])->name('teacher.briefs.competences');
    Route::get('/briefs/{brief_id}/students/{student_id}/livrable', [TeacherController::class, 'checkLivrable'])->name('teacher.briefs.livrable.check');
    Route::get('/progression', [TeacherController::class, 'progression'])->name('teacher.progression');
    Route::get('/progression/data/{id}', [TeacherController::class, 'getStudentProgressionData'])->name('teacher.progression.data');
    Route::get('/students/{id}/livrables', [TeacherController::class, 'studentLivrables'])->name('teacher.students.livrables');
});

Route::middleware(['auth', 'role:STUDENT'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/briefs', [StudentController::class, 'briefs'])->name('student.briefs');
    Route::get('/briefs/{id}', [StudentController::class, 'showBrief'])->name('student.briefs.details');
    Route::post('/briefs/{id}/deliver', [StudentController::class, 'storeLivrable'])->name('student.briefs.deliver');
    Route::get('/progression', [StudentController::class, 'progression'])->name('student.progression');
});

Route::get('/debug-dashboard', function () {
    $briefs = App\Models\Brief::with('sprint.classes')
        ->where('start_date', '<=', now())
        ->where('is_assigned', true)
        ->orderBy('start_date', 'desc')
        ->orderBy('id', 'desc')
        ->get();

    return $briefs->map(function($b) {
        return [
            'id' => $b->id,
            'title' => $b->title,
            'start_date' => $b->start_date->format('Y-m-d'),
            'class_ids' => $b->sprint->classes->pluck('id')->toArray(),
        ];
    });
});
