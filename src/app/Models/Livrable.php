<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livrable extends Model
{
    use HasFactory;

    protected $table = 'livrable';

    protected $fillable = [
        'content',
        'coment',
        'student_id',
        'brief_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function brief()
    {
        return $this->belongsTo(Brief::class);
    }
}
