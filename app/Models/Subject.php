<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject';

    protected $fillable = [
        'lecturer_id',
        'name',
    ];

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(
            Classroom::class,
            'classroom_subject',
            'subject_id',
            'classroom_id'

        );
    }
    
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
