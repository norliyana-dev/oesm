<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">{{  __("List of Classroom") }}</h3>

                        <a href="{{ route('classroom.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + Add Classroom
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left w-1/3">Name</th>
                                    <th class="px-4 py-2 text-left w-1/4">Created by</th>
                                    <th class="px-4 py-2 text-left w-1/5">Total Students</th>
                                    <th class="px-4 py-2 text-left w-1/5">Total Subjects</th>
                                    <th class="px-4 py-2 text-left w-1/4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($classrooms as $classroom )
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $classroom->name }}</td>
                                        <td class="px-4 py-3">{{ $classroom->lecturer->name ?? 0 }}</td>
                                        <td class="px-4 py-3">{{ $classroom->students_count ?? 0 }}</td>
                                        <td class="px-4 py-3">{{ $classroom->subjects_count ?? 0 }}</td>
                                        <td class="px-4 py-3 flex gap-2">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('classroom.edit', $classroom->id) }}" class="flex items-center gap-1 px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                                Edit
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('classroom.destroy', $classroom->id) }}" method="POST" class="delete-form" data-name="{{ $classroom->name }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="flex items-center gap-1 px-3 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200" >
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No classrooms found</td>
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
                    text: `"${name}" classroom will be permanently deleted!`,
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