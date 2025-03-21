<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Booking details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <strong>ID:</strong> {{ $booking->id }}
                        </div>
                        <div>
                            <strong>Customer:</strong> {{ $booking->customer_name }}
                        </div>
                        <div>
                            <strong>Phone number:</strong> {{ $booking->customer_phone }}
                        </div>
                        <div>
                            <strong>Email:</strong> {{ $booking->customer_email }}
                        </div>
                        <div>
                            <strong>Rooms:</strong> {{ $booking->rooms->pluck('name')->implode(', ') }}
                        </div>
                        <div>
                            <strong>Start time:</strong> {{ $booking->start_time->format('d.m.Y H:i') }}
                        </div>
                        <div>
                            <strong>End time:</strong> {{ $booking->end_time->format('d.m.Y H:i') }}
                        </div>
                        <div>
                            <strong>Cost:</strong> ${{ $booking->total_price }}
                        </div>
                        <div>
                            <strong>Status:</strong> {{ $booking->status }}
                        </div>
                    </div>
                    <a href="{{ route('bookings.edit', $booking) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Edit</a>
                    <a href="{{ route('bookings.index') }}" class="mt-6 inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
