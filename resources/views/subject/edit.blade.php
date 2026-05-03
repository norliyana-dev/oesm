<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Subject') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">Edit Subject</h3>

                    <form action="{{ route('subject.update', $subject->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Subject Name --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Subject Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name"  value="{{ old('name', $subject->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" placeholder="e.g. Software Engineering" required>
                        </div>

                        {{-- Assign Classroom --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-1">Assign Classrooms
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="classrooms[]" multiple="multiple" class="classrooms-select w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">

                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}"
                                        {{ in_array($classroom->id, $selectedClassrooms ?? []) ? 'selected' : '' }}>
                                        {{ $classroom->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('students')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Buttons --}}
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('subject.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Back</a>

                            <button type="submit"class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('.classrooms-select').select2({
            placeholder: "Select classroom",
            width: '100%'
        });
    });
</script>
    