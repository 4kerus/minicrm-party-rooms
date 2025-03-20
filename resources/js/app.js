import './bootstrap';
import Alpine from 'alpinejs';
import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

window.Alpine = Alpine;
Alpine.start();

function initCalendar() {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin],
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'ru',
            slotMinTime: '08:00:00',
            slotMaxTime: '22:00:00',
            events: '/dashboard/events',
            eventClick: function (info) {
                alert('Бронирование: ' + info.event.title + '\n' + 'Комната: ' + info.event.extendedProps.room + '\n' + 'Начало: ' + info.event.start.toLocaleString('ru') + '\n' + 'Конец: ' + info.event.end.toLocaleString('ru') + '\n' + 'Стоимость: $' + info.event.extendedProps.total_price + '\n' + 'Статус: ' + info.event.extendedProps.status);
            },
            eventTimeFormat: {
                hour: '2-digit', minute: '2-digit', hour12: false
            }
        });
        calendar.render();
    }
}

document.addEventListener('DOMContentLoaded', initCalendar);
