<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Total Exams</p>
                    <p class="text-2xl font-bold">{{ $exams->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Completed</p>
                    <p class="text-2xl font-bold">{{ $completedCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Pending</p>
                    <p class="text-2xl font-bold">{{ $pendingCount }}</p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Subjects Enrolled</p>
                    <p class="text-2xl font-bold">{{ $subjectCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Classes Joined</p>
                    <p class="text-2xl font-bold">{{ $classCount }}</p>
                </div>
            </div>

            {{-- Exam list --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">My Exams</h3>

                <table class="w-full text-left">
                    <thead class="border-b">
                        <tr>
                            <th class="py-2">Exam</th>
                            <th>Subject</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($exams as $exam)

                            @php
                                $submission = $submissions->where('exam_id', $exam->id)->first();
                            @endphp

                            <tr class="border-b">
                                <td class="py-2">{{ $exam->title }}</td>
                                <td>{{ $exam->subject->name ?? '-' }}</td>
                                <td>{{ $exam->duration }} mins</td>

                                <td>
                                    @if ($submission && $submission->is_submitted)
                                        <span class="text-green-600">Completed</span>
                                    @elseif ($submission)
                                        <span class="text-yellow-600">In Progress</span>
                                    @else
                                        <span class="text-gray-500">Not Started</span>
                                    @endif
                                </td>

                                <td>
                                    @if (!$submission || !$submission->is_submitted)
                                        <a href="{{ route('student.exam.start', $exam->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded">
                                            Start
                                        </a>
                                    @else
                                        <span class="text-gray-400">Done</span>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>