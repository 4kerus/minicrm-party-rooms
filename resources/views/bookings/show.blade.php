<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Детали бронирования</h2>
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
                            <strong>Клиент:</strong> {{ $booking->customer_name }}
                        </div>
                        <div>
                            <strong>Телефон:</strong> {{ $booking->customer_phone }}
                        </div>
                        <div>
                            <strong>Email:</strong> {{ $booking->customer_email }}
                        </div>
                        <div>
                            <strong>Комната:</strong> {{ $booking->room->name }}
                        </div>
                        <div>
                            <strong>Время начала:</strong> {{ $booking->start_time->format('d.m.Y H:i') }}
                        </div>
                        <div>
                            <strong>Время окончания:</strong> {{ $booking->end_time->format('d.m.Y H:i') }}
                        </div>
                        <div>
                            <strong>Стоимость:</strong> ${{ $booking->total_price }}
                        </div>
                        <div>
                            <strong>Статус:</strong> {{ $booking->status }}
                        </div>
                    </div>
                    <a href="{{ route('bookings.index') }}" class="mt-6 inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Назад</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
