<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">
                            {{ __("My Assigned Classroom") }}
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left w-1/3">Classroom Name</th>
                                    <th class="px-4 py-2 text-left w-1/3">Subjects</th>
                                    <th class="px-4 py-2 text-left w-1/3">Total Subjects</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($classrooms as $classroom)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $classroom->name }}</td>
                                        <td class="px-4 py-3">
                                            @foreach ($classroom->subjects as $subject)
                                                <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm mr-1 mb-1">
                                                    {{ $subject->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-3">{{ $classroom->subjects->count() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-gray-500">No classroom assigned</td>
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