<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subject') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">{{  __("List of Subject") }}</h3>

                        <a href="{{ route('subject.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + Add Subject
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left w-1/3">Subject</th>
                                    <th class="px-4 py-2 text-left w-1/4">Created by</th>
                                    <th class="px-4 py-2 text-left w-1/5">Total Class</th>
                                    <th class="px-4 py-2 text-left w-1/5">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subjects as $subject )
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $subject->name }}</td>
                                        <td class="px-4 py-3">{{ $subject->lecturer->name ?? 0 }}</td>
                                        <td class="px-4 py-3">{{ $subject->classrooms_count ?? 0 }}</td>
                                        <td class="px-4 py-3 flex gap-2">

                                            <a href="{{ route('subject.edit', $subject->id) }}" class="flex items-center gap-1 px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                                Edit
                                            </a>
                                           
                                            <form action="{{ route('subject.destroy', $subject->id) }}" method="POST" class="delete-form" data-name="{{ $subject->name }}">
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
                                        <td colspan="3" class="px-4 py-4 text-center text-gray-500">No subjects found</td>
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