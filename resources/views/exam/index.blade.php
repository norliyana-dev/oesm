<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">{{  __("List of Exam") }}</h3>

                        <a href="{{ route('exam.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + Add Exam
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left w-4/12">Title</th>
                                    <th class="px-4 py-2 text-left w-2/12">Created by</th>
                                    <th class="px-4 py-2 text-left w-1/12">Duration</th>
                                    <th class="px-4 py-2 text-left w-2/12">Start At</th>
                                    <th class="px-4 py-2 text-left w-2/12">End At</th>
                                    <th class="px-4 py-2 text-left w-1/12">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exams as $exam)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium">{{ $exam->title }}</td>
                                        <td class="px-4 py-3">{{ $exam->creator->name ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $exam->duration }} mins</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($exam->start_at)->format('d-m-Y H:i') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($exam->end_at)->format('d-m-Y H:i') }}</td>
                                        <td class="px-4 py-3 flex gap-2">
                                            <a href="{{ route('exam.questions.index', $exam->id) }}" class="px-3 py-1 text-sm bg-green-100 text-green-600 rounded hover:bg-green-200">
                                                Questions
                                            </a>

                                            <a href="{{ route('exam.edit', $exam->id) }}"class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                                Edit
                                            </a>

                                            <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" class="delete-form" data-name="{{ $exam->title }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="px-3 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No exams found</td>
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

        const forms = document.querySelectorAll('.delete-form');

        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                let name = form.getAttribute('data-name');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `"${name}" will be permanently deleted!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });
        });

    });
</script>