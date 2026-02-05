<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // -----------------------------
    // Fillable & Hidden
    // -----------------------------
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'classe_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // -----------------------------
    // Role helper methods
    // -----------------------------
    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'TEACHER';
    }

    public function isStudent(): bool
    {
        return $this->role === 'STUDENT';
    }

    // -----------------------------
    // Query scopes by role
    // -----------------------------
    public function scopeAdmins($query)
    {
        return $query->where('role', 'ADMIN');
    }

    public function scopeTeachers($query)
    {
        return $query->where('role', 'TEACHER');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'STUDENT');
    }

    // -----------------------------
    // STUDENT relationships
    // -----------------------------
    // Class the student belongs to
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    // Livrables submitted by the student
    public function livrables()
    {
        return $this->hasMany(Livrable::class, 'student_id');
    }

    // Debriefings received by the student
    public function studentDebriefings()
    {
        return $this->hasMany(Debriefing::class, 'student_id');
    }

    // -----------------------------
    // TEACHER relationships
    // -----------------------------
    // All assigned classes (primary + backup)
    public function classes()
    {
        return $this->belongsToMany(
            Classe::class,
            'classe_teacher',
            'teacher_id',
            'classe_id'
        )->withTimestamps();
    }

    // Primary class of the teacher (from users.classe_id)
    public function primaryClass()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    // Backup classes (all assigned classes except primary)
    public function backupClasses()
    {
        return $this->classes()->where('classe_id', '!=', $this->classe_id);
    }

    // Briefs created by the teacher
    public function briefs()
    {
        return $this->hasMany(Brief::class, 'teacher_id');
    }

    // Debriefings created by the teacher
    public function teacherDebriefings()
    {
        return $this->hasMany(Debriefing::class, 'teacher_id');
    }


}
