<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit booking</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ $errors->first() }}</div>
                    @endif
                    <form method="POST" action="{{ route('bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                            <input type="text" name="customer_name"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('customer_name') border-red-300 @enderror"
                                   value="{{ old('customer_name', $booking->customer_name) }}">
                            @error('customer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Customer phone number</label>
                            <input type="text" name="customer_phone"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('customer_phone') border-red-300 @enderror"
                                   value="{{ old('customer_phone', $booking->customer_phone) }}">
                            @error('customer_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="customer_email"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('customer_email') border-red-300 @enderror"
                                   value="{{ old('customer_email', $booking->customer_email) }}">
                            @error('customer_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Rooms</label>
                            <div class="mt-2 space-y-2 max-h-48 overflow-y-auto border p-2 rounded @error('room_ids') border-red-300 @enderror">
                                @foreach ($rooms as $room)
                                    <div class="flex items-center">
                                        <input

                                            type="checkbox"
                                            name="room_ids[]"
                                            value="{{ $room->id }}"
                                            id="room_{{ $room->id }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ in_array($room->id, old('room_ids', $booking->rooms->pluck('id')->toArray())) ? 'checked' : '' }}
                                        >
                                        <label for="room_{{ $room->id }}"
                                               class="ml-2 text-sm text-gray-600">{{ $room->name }}
                                            ({{$room->price_per_hour}} € / hour)</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('room_ids')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Start time</label>
                            <input type="datetime-local" name="start_time"
                                   value="{{ old('start_time', $booking->start_time->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('start_time') border-red-300 @enderror">
                            @error('start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">End time</label>
                            <input type="datetime-local" name="end_time"
                                   value="{{ old('end_time', $booking->end_time->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('end_time') border-red-300 @enderror">
                            @error('end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('status') border-red-300 @enderror">
                                <option
                                    value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>
                                    pending
                                </option>
                                <option
                                    value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>
                                    confirmed
                                </option>
                                <option
                                    value="canceled" {{ old('status', $booking->status) == 'canceled' ? 'selected' : '' }}>
                                    canceled
                                </option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update
                        </button>
                        <a href="{{ route('bookings.index') }}"
                           class="ml-4 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
