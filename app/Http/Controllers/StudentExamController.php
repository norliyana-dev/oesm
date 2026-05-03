<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $classroomIds = $user->classrooms->pluck('id');

        $subjectIds = DB::table('classroom_subject')
            ->whereIn('classroom_id', $classroomIds)
            ->pluck('subject_id');

        $exams = Exam::with('subject')
            ->whereIn('subject_id', $subjectIds)
            ->orderBy('start_at', 'asc')
            ->get();

        $submissions = Submission::where('student_id', $user->id)
            ->get()
            ->keyBy('exam_id');

        return view('student.exam.index', compact('exams', 'submissions'));
    }

    public function start(Exam $exam)
    {
        $user = auth()->user();

        $submission = Submission::updateOrCreate(
            [
                'student_id' => $user->id,
                'exam_id'   => $exam->id,
            ],
            [
                'started_at' => now(),
                'submitted_at' => now()->addMinutes($exam->duration),
            ]
        );

        if (now()->greaterThan($submission->submitted_at)) {
            return redirect()->route('student.exam.index')
                ->with('error', 'Exam time is already over.');
        }

        $exam->load('questions', 'subject'); 

        return view('student.exam.start', compact('exam', 'submission'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $user = auth()->user();

         $request->validate([
            'answers' => 'required|array'
        ]);

        $submission = Submission::where('student_id', $user->id)
            ->where('exam_id', $exam->id)
            ->firstOrFail();

        if ($submission->is_submitted) {
            return redirect()->route('student.exam')
                ->with('error', 'You already submitted this exam.');
        }

        foreach ($request->answers as $questionId => $answer) {
            $question = Question::find($questionId);

            if (!$question) continue;

            $isCorrect = null;
            $marksAwarded = 0;

            if ($question->type === 'mcq') {

                $correctOption = $question->options()
                    ->where('option_text', $answer)
                    ->where('is_correct', 1)
                    ->first();

                $isCorrect = $correctOption ? 1 : 0;
                $marksAwarded = $isCorrect ? $question->marks : 0;

                Answer::create([
                    'submission_id'   => $submission->id,
                    'question_id'     => $questionId,
                    'selected_option' => $answer,
                    'answer_text'     => null,
                    'is_correct'      => $isCorrect,
                    'marks_awarded'   => $marksAwarded,
                ]);

            } else {

                Answer::create([
                    'submission_id'   => $submission->id,
                    'question_id'     => $questionId,
                    'answer_text'     => $answer,

                    'selected_option' => null,
                    'is_correct'      => null,
                    'marks_awarded'   => 0,
                ]);
            }
        }

        $submission->update([
            'is_submitted' => true,
            'submitted_at' => now(), 
        ]);

        return redirect()->route('student.exam')
            ->with('success', 'Exam submitted successfully');
    }
}
