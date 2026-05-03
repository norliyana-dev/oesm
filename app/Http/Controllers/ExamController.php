<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::with([
            'creator',
            'classroom',
            'subject'
        ])
        ->where('created_by', auth()->id())
        ->get();

        return view('exam.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::with('subjects')
            ->where('lecturer_id', auth()->id())
            ->get();
     
        return view('exam.create', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'start_at'       => 'required|date|after_or_equal:now',
            'end_at'         => 'required|date|after:start_at',
            'duration'       => 'required|integer|min:1',
            'classroom_id'   => 'required|exists:classroom,id',
            'subject_id'     => 'required|exists:subject,id',

        ]);

        $exam = Exam::create([
            'classroom_id'  => $request->classroom_id,
            'subject_id'    => $request->subject_id,
            'created_by'    => auth()->id(),
            'title'         => $request->title,
            'description'   => $request->description,
            'start_at'      => $request->start_at,
            'end_at'        => $request->end_at,
            'duration'      => $request->duration,
            'visibility'    => 'draft'
        ]);
        
        return redirect()->route('exam.index')
            ->with('success', 'Exam created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $exam->load(['classroom', 'subject']);

        $classrooms = Classroom::with('subjects')
            ->where('lecturer_id', auth()->id())
            ->get();
   
        return view('exam.edit', compact('exam', 'classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'start_at'     => 'required|date|after_or_equal:now',
            'end_at'       => 'required|date|after:start_at',
            'duration'     => 'required|integer|min:1|max:300',
            'classroom_id' => 'required|exists:classroom,id',
            'subject_id'   => [
                'required',
                Rule::exists('classroom_subject', 'subject_id')
                    ->where('classroom_id', $request->classroom_id),
            ],
        ]);

        $exam->update([
            'classroom_id' => $request->classroom_id,
            'subject_id'   => $request->subject_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'start_at'     => $request->start_at,
            'end_at'       => $request->end_at,
            'duration'     => $request->duration,
        ]);

        return redirect()->route('exam.index')
            ->with('success', 'Exam updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $classroom)
    {
        $classroom->delete();

        return redirect()->route('exam.index')
            ->with('success', 'Exam deleted successfully');
    }
}
