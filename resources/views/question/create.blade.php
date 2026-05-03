<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('exam.questions.store', $exam) }}">
                        @csrf

                        {{-- Type --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Question Type</label>
                            <select id="type" name="type" class="w-full border-gray-300 rounded-lg shadow-sm" onchange="toggleOptions()">
                                <option value="mcq">MCQ</option>
                                <option value="open">Open Text</option>
                            </select>
                        </div>

                        {{-- Question --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Question</label>
                            <textarea name="question_text" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm" required></textarea>
                        </div>

                        {{-- Marks --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Marks</label>
                            <input type="number" name="marks" value="1" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- MCQ --}}
                        <div id="optionsSection">
                            <label class="block text-sm font-medium mb-1">Answer Options</label>

                            <div id="optionsContainer" class="space-y-3">
                                <div class="flex items-center gap-3 option-item">
                                    <input type="radio" name="correct_index" value="0">
                                    <input type="text" name="options[]" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Enter option">
                                </div>

                                <div class="flex items-center gap-3 option-item">
                                    <input type="radio" name="correct_index" value="1">
                                    <input type="text" name="options[]" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Enter option">
                                </div>
                            </div>

                            <button type="button" onclick="addOption()" class="text-sm text-blue-500 mt-2">
                                + Add Option
                            </button>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('exam.questions.index', $exam->id) }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Back</a>

                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
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

function addOption() {
    let container = document.getElementById('optionsContainer');
    let index = container.children.length;

    let wrapper = document.createElement('div');
    wrapper.className = 'flex items-center gap-3 option-item';

    let radio = document.createElement('input');
    radio.type = 'radio';
    radio.name = 'correct_index';
    radio.value = index;

    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = 'Enter option';
    input.className = 'w-full border-gray-300 rounded-lg shadow-sm';

    wrapper.appendChild(radio);
    wrapper.appendChild(input);

    container.appendChild(wrapper);
}
</script>