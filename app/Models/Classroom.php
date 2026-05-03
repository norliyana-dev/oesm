<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classroom';

    protected $fillable = [
        'lecturer_id',
        'name',
    ];

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class, 
            'classroom_student',
            'classroom_id',
            'student_id'
        );
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'classroom_subject',
            'classroom_id',
            'subject_id'
        );
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
