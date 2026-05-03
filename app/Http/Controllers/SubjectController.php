<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('lecturer')
            ->withCount('classrooms')
            ->where('lecturer_id', auth()->id())
            ->get();

        return view('subject.index', compact('subjects'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        $subject = Subject::create([
            'lecturer_id'   => auth()->id(),
            'name'          => $request->name,
        ]);

        return redirect()->route('subject.edit', $subject)
            ->with('success', 'Subject created successfully. You may assign classrooms now.');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $classrooms = Classroom::all();

        $selectedClassrooms = $subject->classrooms->pluck('id')->toArray();

        return view('subject.edit', compact('subject', 'classrooms', 'selectedClassrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'classrooms'    => 'required|array|min:1',
            'classrooms.*'  => 'exists:classroom,id',
        ]);

        $subject->update([
            'name'          => $request->name,
        ]);

        $subject->classrooms()->sync($request->classrooms);

        return redirect()->route('subject.index')
            ->with('success', 'Subject updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subject.index')
            ->with('success', 'Subject deleted successfully');
    }
}
