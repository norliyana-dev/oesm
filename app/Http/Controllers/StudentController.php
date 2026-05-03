<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function myClassroom()
    {
        $user = auth()->user();
        $classrooms = $user->classrooms()->with('subjects')->get();

        return view('student.classroom', compact('classrooms'));
    }
}
