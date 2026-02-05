<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brief extends Model
{
    use HasFactory;

    protected $table = 'brief';

    protected $fillable = [
        'title',
        'content',
        'start_date',
        'end_date',
        'type',
        'is_assigned',
        'sprint_id',
        'teacher_id',
    ];

    protected $casts = [
        'is_assigned' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function competences()
    {
        return $this->belongsToMany(
            Competence::class,
            'brief_competence',
            'brief_id',
            'competence_code'
        );
    }

    public function livrables()
    {
        return $this->hasMany(Livrable::class);
    }

    public function debriefings()
    {
        return $this->hasMany(Debriefing::class);
    }
}
