<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Room
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('rooms.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('name') border-red-300 @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('description') border-red-300 @enderror" id="description" name="description">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="price_per_hour" class="block text-sm font-medium text-gray-700">Price per Hour</label>
                            <input type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('price_per_hour') border-red-300 @enderror" id="price_per_hour" name="price_per_hour" value="{{ old('price_per_hour') }}">
                            @error('price_per_hour') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('capacity') border-red-300 @enderror" id="capacity" name="capacity" value="{{ old('capacity') }}">
                            @error('capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-x-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-black rounded hover:bg-indigo-700">Create</button>
                            <a href="{{ route('rooms.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
