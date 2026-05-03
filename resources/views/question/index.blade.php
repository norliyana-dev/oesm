<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-semibold">{{ $exam->title }}</h3>
                            <p class="text-sm text-gray-500">List of Questions</p>
                        </div>

                        <a href="{{ route('exam.questions.create', $exam->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + Add Question
                        </a>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border border-gray-200 rounded-lg">

                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left w-2/6">Question</th>
                                    <th class="px-4 py-2 text-left w-1/6">Type</th>
                                    <th class="px-4 py-2 text-left w-1/6">Marks</th>
                                    <th class="px-4 py-2 text-left w-1/6">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($exam->questions as $question)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            {{ $question->question_text }}
                                        
                                            {{-- MCQ options --}}
                                            @if ($question->type == 'mcq')
                                                <ul class="mt-2 text-sm text-gray-600 list-disc pl-5">
                                                    @foreach ($question->options as $option)
                                                        <li class="{{ $option->is_correct ? 'text-green-600 font-semibold' : '' }}">
                                                            {{ $option->option_text }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 uppercase">{{ $question->type }}</td>
                                        <td class="px-4 py-3">{{ $question->marks }}</td>
                                        <td class="px-4 py-3 flex gap-2">
                                            {{-- Edit --}}
                                            <a href="{{ route('exam.questions.edit', [$exam->id, $question->id]) }}"
                                               class="flex items-center gap-1 px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                                Edit
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('exam.questions.destroy', [$exam->id, $question->id]) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">No questions found</td>
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
                    text: "This question will be permanently deleted!",
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