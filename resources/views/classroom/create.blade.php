<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">Add New Classroom</h3>

                    <form action="{{ route('classroom.store') }}" method="POST">
                        @csrf

                        {{-- Classroom Name --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Classroom Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" placeholder="e.g. DIT 2023" required>
                        </div>

                        {{-- Assign Student --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-1">Assign Students
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="students[]" multiple="multiple" class="students-select w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>

                            @error('students')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Buttons --}}
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('classroom.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Back</a>

                            <button type="submit"class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('.students-select').select2({
            placeholder: "Select students",
            width: '100%'
        });
    });
</script>
    