<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bookings</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('bookings.create') }}" class="mb-4 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add New
                        Booking</a>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Rooms</th>
                            <th class="px-6 py-3">Start</th>
                            <th class="px-6 py-3">End</th>
                            <th class="px-6 py-3">Cost</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4">{{ $booking->id }}</td>
                                <td class="px-6 py-4">{{ $booking->customer_name }}</td>
                                <td class="px-6 py-4">{{ $booking->rooms->pluck('name')->implode(', ') }}</td>
                                <td class="px-6 py-4">{{ $booking->start_time->format('d.m.Y H:i') }}</td>
                                <td class="px-6 py-4">{{ $booking->end_time->format('d.m.Y H:i') }}</td>
                                <td class="px-6 py-4">${{ $booking->total_price }}</td>
                                <td class="px-6 py-4">{{ $booking->status }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                    <a href="{{ route('bookings.edit', $booking) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Вы уверены?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
