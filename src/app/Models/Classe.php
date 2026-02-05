<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'year',
    ];

    /* ================= Relationships ================= */

    public function students()
    {
        return $this->hasMany(User::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(
            User::class,
            'classe_teacher',
            'classe_id',
            'teacher_id'
        );
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
}
