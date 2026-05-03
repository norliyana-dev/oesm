<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::withCount(['students', 'subjects'])
            ->where('lecturer_id', auth()->id())
            ->get();

        return view('classroom.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::role('student')->get();

        return view('classroom.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'students'      => 'required|array|min:1',
            'students.*'    => 'exists:users,id',
        ]);

        $classroom = Classroom::create([
            'lecturer_id'   => auth()->id(),
            'name'          => $request->name,
        ]);

        $classroom->students()->attach($request->students);

        return redirect()->route('classroom.index')
            ->with('success', 'Classroom created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        $students = User::role('student')->get();

        $selectedStudents = $classroom->students->pluck('id')->toArray();

        return view('classroom.edit', compact('classroom', 'students', 'selectedStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'students'      => 'required|array|min:1',
            'students.*'    => 'exists:users,id',
        ]);

        $classroom->update([
            'name'          => $request->name,
        ]);

        $classroom->students()->sync($request->students);

        return redirect()->route('classroom.index')
            ->with('success', 'Classroom updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('classroom.index')
            ->with('success', 'Classroom deleted successfully');
    }
}
