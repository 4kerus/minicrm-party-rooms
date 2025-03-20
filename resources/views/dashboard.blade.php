<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'ru',
                slotMinTime: '08:00:00',
                slotMaxTime: '22:00:00',
                events: '{{ route('dashboard.events') }}',
                eventClick: function(info) {
                    alert(
                        'Бронирование: ' + info.event.title + '\n' +
                        'Комната: ' + info.event.extendedProps.room + '\n' +
                        'Начало: ' + info.event.start.toLocaleString('ru') + '\n' +
                        'Конец: ' + info.event.end.toLocaleString('ru') + '\n' +
                        'Стоимость: $' + info.event.extendedProps.total_price + '\n' +
                        'Статус: ' + info.event.extendedProps.status
                    );
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>
