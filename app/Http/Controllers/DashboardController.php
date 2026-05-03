<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match (true) {
            $user->hasRole('student') => $this->studentDashboard($user),
            $user->hasRole('lecturer') => $this->lecturerDashboard($user),
            default => abort(403),
        };
    }

    private function studentDashboard($user)
    {
        $classrooms = $user->classrooms;

        $classroomIds = $classrooms->pluck('id');

        $subjectIds = DB::table('classroom_subject')
            ->whereIn('classroom_id', $classroomIds)
            ->pluck('subject_id');

        $exams = Exam::with('subject')
            ->whereIn('subject_id', $subjectIds)
            ->orderBy('start_at', 'desc')
            ->get();

        $submissions = Submission::where('student_id', $user->id)->get();
        $completedCount = $submissions->where('is_submitted', true)->count();
        $pendingCount = $submissions->where('is_submitted', false)->count();
        $subjectCount = $subjectIds->unique()->count();
        $classCount = $classrooms->count();

        return view('dashboard.student', compact(
            'exams',
            'submissions',
            'completedCount',
            'pendingCount',
            'subjectCount', 
            'classCount'
        ));
    }

    private function lecturerDashboard($user)
    {
        $classrooms = Classroom::where('lecturer_id', $user->id)->get();

        $classroomIds = $classrooms->pluck('id');

        $studentsCount = DB::table('classroom_student')
            ->whereIn('classroom_id', $classroomIds)
            ->count();

        $subjectsCount = DB::table('classroom_subject')
            ->whereIn('classroom_id', $classroomIds)
            ->count();

        $exams = Exam::with('subject')
            ->whereIn('classroom_id', $classroomIds)
            ->latest()
            ->take(5)
            ->get();

        $totalExams = Exam::whereIn('classroom_id', $classroomIds)->count();

        $activeExams = Exam::whereIn('classroom_id', $classroomIds)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->count();

        $totalSubmissions = Submission::whereHas('exam', function ($q) use ($classroomIds) {
            $q->whereIn('classroom_id', $classroomIds);
        })->count();

        return view('dashboard.lecturer', compact(
            'classrooms',
            'studentsCount',
            'subjectsCount',
            'exams',
            'totalExams',
            'activeExams',
            'totalSubmissions'
        ));
    }
}