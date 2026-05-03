<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        $exam->load('questions.options');

        return view('question.index', compact('exam'));
    }

    public function create(Exam $exam)
    {
        return view('question.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'type'          => 'required|in:mcq,open',
            'question_text' => 'required|string',
            'marks'         => 'required|integer|min:1',
        ]);

        if ($request->type === 'mcq') {

            $options = array_values(array_filter($request->options ?? []));

            if (count($options) < 2) {
                return back()->withErrors([
                    'options' => 'At least 2 options are required'
                ])->withInput();
            }

            if (!isset($request->correct_index) || $request->correct_index >= count($options)) {
                return back()->withErrors([
                    'correct_index' => 'Please select a valid correct answer'
                ])->withInput();
            }

            validator([
                'options' => $options,
            ], [
                'options.*' => 'required|string|distinct'
            ])->validate();

            $request->merge(['options' => $options]);
        }

        $question = $exam->questions()->create([
            'question_text' => $request->question_text,
            'type'          => $request->type,
            'marks'         => $request->marks,
        ]);

        if ($request->type === 'mcq') {

            foreach ($request->options as $index => $optionText) {

                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => ($index == $request->correct_index),
                ]);
            }
        }

        return redirect()->route('exam.questions.index', $exam->id)
            ->with('success', 'Question added successfully');
    }

    public function edit(Exam $exam, Question $question)
    {
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        return view('question.edit', compact('exam', 'question'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $request->validate([
            'type'          => 'required|in:mcq,open',
            'question_text' => 'required|string',
            'marks'         => 'required|integer|min:1',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'type'          => $request->type,
            'marks'         => $request->marks,
        ]);

        if ($request->type === 'mcq') {

            $options = array_values(array_filter($request->options ?? []));

            if (count($options) < 2) {
                return back()->withErrors([
                    'options' => 'At least 2 options are required'
                ])->withInput();
            }

            if (!isset($request->correct_index) || $request->correct_index >= count($options)) {
                return back()->withErrors([
                    'correct_index' => 'Please select a valid correct answer'
                ])->withInput();
            }

            validator([
                'options' => $options,
            ], [
                'options.*' => 'required|string|distinct'
            ])->validate();

            $question->options()->delete();

            foreach ($options as $index => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct'  => ($index == $request->correct_index),
                ]);
            }
        }

        return redirect()->route('exam.questions.index', $exam->id)
            ->with('success', 'Question updated successfully');
    }

    public function destroy(Exam $exam, Question $question)
    {
        $question->options()->delete();
        $question->delete();

        return redirect()->route('exam.questions.index', $exam->id)
            ->with('success', 'Question deleted successfully');
    }
}

