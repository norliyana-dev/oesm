<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Exam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">Edit Exam</h3>

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
                    
                    <form action="{{ route('exam.update', $exam->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Exam title --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Exam Title
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ $exam->title }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" placeholder="e.g. Internet Programming Final Exam" required>
                        </div>

                        {{-- Exam description --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Exam Description</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" placeholder="Description">{{ $exam->description }}</textarea>
                        </div>

                        {{-- Start at --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Start At
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="start_at" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ $exam->start_at }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                        </div>

                        {{-- End at --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">End At
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_at" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ $exam->end_at }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                        </div>

                        {{-- Duration --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Exam Duration (minutes)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" min="1" name="duration" min="1" max="300" value="{{ $exam->duration }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" placeholder="e.g. 60" required>
                        </div>

                        {{-- Classroom --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Classroom 
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="classroom_id" id="classroom" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                                <option value="">Select Classroom</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}"
                                        {{ $exam->classroom_id == $classroom->id ? 'selected' : '' }}>
                                        {{ $classroom->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Subject --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Subject
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="subject_id" id="subject" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"required>
                                <option value="">Select Subject</option>
                            </select>
                        </div>
                                                
                        {{-- Buttons --}}
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('exam.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Back</a>

                            <button type="submit"class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const selectedSubjectId = "{{ $exam->subject_id }}";
    
    const classrooms = @json($classrooms);

    function loadSubjects(classroomId) {
        let subjectSelect = document.getElementById('subject');

        subjectSelect.innerHTML = '<option value="">Select Subject</option>';

        let selectedClassroom = classrooms.find(c => c.id == classroomId);

        if (selectedClassroom) {
            selectedClassroom.subjects.forEach(subject => {
                let option = document.createElement('option');
                option.value = subject.id;
                option.text = subject.name;

                subjectSelect.appendChild(option);
            });
        }

        if (selectedSubjectId) {
            subjectSelect.value = selectedSubjectId;
        }
    }

    document.getElementById('classroom').addEventListener('change', function () {
        loadSubjects(this.value);
    });

    window.addEventListener('load', function () {
        let classroomId = document.getElementById('classroom').value;

        if (classroomId) {
            loadSubjects(classroomId);
        }
    });
</script>