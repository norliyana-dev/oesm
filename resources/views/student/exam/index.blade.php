<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="font-semibold mb-4">Exam List</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border border-gray-200 rounded-lg">

                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Exam</th>
                                    <th class="px-4 py-2 text-left">Subject</th>
                                    <th class="px-4 py-2 text-left">Start</th>
                                    <th class="px-4 py-2 text-left">End</th>
                                    <th class="px-4 py-2 text-left">Duration</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($exams as $exam)

                                    @php
                                        $now = now();

                                        if ($now < $exam->start_at) {
                                            $status = 'Upcoming';
                                            $statusColor = 'text-yellow-600';
                                        } elseif ($now >= $exam->start_at && $now <= $exam->end_at) {
                                            $status = 'Available';
                                            $statusColor = 'text-green-600';
                                        } else {
                                            $status = 'Expired';
                                            $statusColor = 'text-red-600';
                                        }

                                        $submission = $submissions[$exam->id] ?? null;
                                    @endphp

                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $exam->title }}</td>
                                        <td class="px-4 py-3">{{ $exam->subject->name ?? '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($exam->start_at)->format('d-m-Y H:i') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($exam->end_at)->format('d-m-Y H:i') }}</td>
                                        <td class="px-4 py-3">{{ $exam->duration }} mins</td>
                                        <td class="px-4 py-3 {{ $statusColor }}">{{ $status }}</td>
                                        <td class="px-4 py-3">
                                            @if ($submission && $submission->is_submitted)
                                                <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded">
                                                    Completed
                                                </span>
                                            @elseif ($status === 'Available')
                                                <button type="button" class="start-exam-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" data-id="{{ $exam->id }}" data-duration="{{ $exam->duration }}">
                                                    Start
                                                </button>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-gray-500">
                                            No exams available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.start-exam-btn').forEach(btn => {

        btn.addEventListener('click', function (e) {

            e.preventDefault();

            let examId = this.getAttribute('data-id');
            let duration = this.getAttribute('data-duration');

            Swal.fire({
                title: 'Start Exam?',
                text: `This exam will run for ${duration} minutes. Once started, the timer will begin and cannot be paused or cancelled.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Start Now',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = `/student/exams/${examId}/start`;
                }

            });

        });

    });

});
</script>