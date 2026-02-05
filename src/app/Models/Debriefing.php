<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Debriefing extends Model
{
    use HasFactory;

    protected $table = 'debriefing';

    protected $fillable = [
        'comment',
        'student_id',
        'teacher_id',
        'brief_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function brief()
    {
        return $this->belongsTo(Brief::class);
    }

    public function competences()
    {
        return $this->belongsToMany(
            Competence::class,
            'competence_debriefing',
            'debriefing_id',
            'competence_code'
        )->withPivot(['niveau', 'status']);
    }
}
