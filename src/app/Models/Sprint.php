<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sprint extends Model
{
    use HasFactory;


    protected $table = 'sprints';
       public $timestamps = false;
    protected $fillable = [
        'name',
        'duration',
        'order',
    ];

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_sprint', 'sprint_id', 'classe_id')->withTimestamps();
    }

    public function briefs()
    {
        return $this->hasMany(Brief::class);
    }
}
