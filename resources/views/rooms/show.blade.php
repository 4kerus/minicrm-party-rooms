<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-2"><strong>Description:</strong> {{ $room->description }}</p>
                    <p class="mb-2"><strong>Price per Hour:</strong> ${{ $room->price_per_hour }}</p>
                    <p class="mb-4"><strong>Capacity:</strong> {{ $room->capacity }}</p>
                    <div class="space-x-2">
                        <a href="{{ route('rooms.edit', $room) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Edit</a>
                        <a href="{{ route('rooms.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
