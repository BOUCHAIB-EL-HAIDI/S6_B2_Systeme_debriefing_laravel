<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competence extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'label',
    ];

    public function briefs()
    {
        return $this->belongsToMany(
            Brief::class,
            'brief_competence',
            'competence_code',
            'brief_id'
        );
    }

    public function debriefings()
    {
        return $this->belongsToMany(
            Debriefing::class,
            'competence_debriefing',
            'competence_code',
            'debriefing_id'
        )->withPivot(['niveau', 'status']);
    }
}
