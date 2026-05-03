<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lecturer Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- SUMMARY CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Total Classrooms</p>
                    <p class="text-2xl font-bold">{{ $classrooms->count() }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Total Students</p>
                    <p class="text-2xl font-bold">{{ $studentsCount }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500">Total Subjects</p>
                    <p class="text-2xl font-bold">{{ $subjectsCount }}</p>
                </div>

            </div>

            {{-- CLASSROOM LIST --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">My Classrooms</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    @forelse ($classrooms as $classroom)
                        <div class="border rounded-lg p-4 hover:bg-gray-50">
                            <p class="font-semibold text-lg">
                                {{ $classroom->name ?? 'Classroom' }}
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Created: {{ $classroom->created_at->format('d M Y') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500">No classrooms assigned.</p>
                    @endforelse

                </div>
            </div>

            {{-- RECENT EXAMS --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Recent Exams</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Exam</th>
                            <th>Subject</th>
                            <th>Duration</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($exams as $exam)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $exam->title }}</td>
                                <td>{{ $exam->subject->name ?? '-' }}</td>
                                <td>{{ $exam->duration }} mins</td>
                                <td>{{ $exam->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    No exams created yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>