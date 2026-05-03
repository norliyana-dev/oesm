<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('exam.questions.update', [$exam->id, $question->id]) }}">
                        @csrf
                        @method('PUT')

                        {{-- Type --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Question Type</label>
                            <select id="type" name="type" class="w-full border-gray-300 rounded-lg shadow-sm" onchange="toggleOptions()">
                                <option value="mcq" {{ $question->type == 'mcq' ? 'selected' : '' }}>MCQ</option>
                                <option value="open" {{ $question->type == 'open' ? 'selected' : '' }}>Open Text</option>
                            </select>
                        </div>

                        {{-- Question --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Question</label>
                            <textarea name="question_text" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm" required>{{ old('question_text', $question->question_text) }}</textarea>
                        </div>

                        {{-- Marks --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Marks</label>
                            <input type="number" name="marks" value="{{ old('marks', $question->marks) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- MCQ --}}
                        <div id="optionsSection">
                            <label class="block text-sm font-medium mb-1">Answer Options</label>
                            <div id="optionsContainer" class="space-y-3">
                                @foreach ($question->options as $i => $option)
                                    <div class="flex items-center gap-3 option-item">
                                        <input type="radio" name="correct_index" class="correct-radio" {{ $option->is_correct ? 'checked' : '' }}>
                                        <input type="text" name="options[]" value="{{ $option->option_text }}" class="w-full border-gray-300 rounded-lg shadow-sm option-input" placeholder="Enter option">

                                        <button type="button" onclick="removeOption(this)" class="text-red-500 text-sm">✕</button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" onclick="addOption()" class="text-sm text-blue-500 mt-2">+ Add Option</button>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('exam.questions.index', $exam->id) }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Back</a>

                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
function toggleOptions() {
    let type = document.getElementById('type').value;
    document.getElementById('optionsSection').style.display =
        type === 'mcq' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', toggleOptions);

function addOption() {
    let container = document.getElementById('optionsContainer');

    let wrapper = document.createElement('div');
    wrapper.className = 'flex items-center gap-3 option-item';

    wrapper.innerHTML = `
        <input type="radio" name="correct_index" class="correct-radio">
        <input type="text" name="options[]" class="w-full border-gray-300 rounded-lg shadow-sm option-input" placeholder="Enter option">
        <button type="button" onclick="removeOption(this)" class="text-red-500 text-sm">✕</button>
    `;

    container.appendChild(wrapper);

    reindexOptions();
}

function removeOption(button) {
    let container = document.getElementById('optionsContainer');

    if (container.children.length <= 2) {
        alert('MCQ must have at least 2 options');
        return;
    }

    button.parentElement.remove();
    reindexOptions();
}

function reindexOptions() {
    let container = document.getElementById('optionsContainer');
    let items = container.querySelectorAll('.option-item');

    items.forEach((item, index) => {
        let radio = item.querySelector('.correct-radio');
        radio.value = index;
    });
}

document.querySelector('form').addEventListener('submit', function () {
    let radios = document.querySelectorAll('.correct-radio');

    radios.forEach(radio => {
        if (radio.checked) {
            radio.setAttribute('checked', true);
        }
    });
});
</script>