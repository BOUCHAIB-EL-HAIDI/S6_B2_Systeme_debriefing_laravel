<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sprint extends Model
{
    use HasFactory;

    protected $table = 'sprint';

    protected $fillable = [
        'name',
        'duration',
        'order',
        'classe_id',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function briefs()
    {
        return $this->hasMany(Brief::class);
    }
}
