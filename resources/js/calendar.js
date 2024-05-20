import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import multiMonthPlugin from '@fullcalendar/multimonth';
import timeGridPlugin from '@fullcalendar/timegrid';
import allLocales from '@fullcalendar/core/locales-all';
import { Modal } from 'bootstrap';
import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

document.addEventListener('DOMContentLoaded', function () {
    var initialLocaleCode = 'es';
    var calendarEl = document.getElementById('calendar');
    var eventModal = new Modal(document.getElementById('eventModal'));
    var editEventModal = new Modal(document.getElementById('editEventModal'));

    var calendar = new Calendar(calendarEl, {
        locales: allLocales,
        locale: 'es',
        plugins: [dayGridPlugin, interactionPlugin, multiMonthPlugin, timeGridPlugin],
        initialView: 'multiMonthYear',
        headerToolbar: {
            left: 'prev,next,today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay,dayGridMonth,multiMonthYear',
        },
        dateClick: function (info) {
            if (calendar.view.type !== 'timeGridDay') {
                calendar.changeView('timeGridDay', info.dateStr);
            } else {
                openEventModal(info.date);
            }
        },
        eventClick: function (info) {
            openEditEventModal(info);
        },
        events: events.map(event => ({
            id: event.id,
            title: event.name,
            description: event.description,
            backgroundColor: event.color,
            start: event.start,
            end: event.end,
        })),
    });

    calendar.render();

    calendar.getAvailableLocaleCodes().forEach(function (localeCode) {
        var optionEl = document.createElement('option');
        optionEl.value = localeCode;
        optionEl.selected = localeCode == initialLocaleCode;
        optionEl.innerText = localeCode;
    });

    function openEventModal(date) {
        document.getElementById('form').reset();

        var localDate = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
        var formattedDate = localDate.toISOString().slice(0, 16);
        document.getElementById('start').value = formattedDate;
        document.getElementById('end').value = formattedDate;

        eventModal.show();
    }

    document.getElementById('btnCerrar').addEventListener('click', function () {
        var eventModalElement = document.getElementById('eventModal');
        var eventModal = Modal.getInstance(eventModalElement);
        if (eventModal) {
            eventModal.hide();
        }
    });

    function openEditEventModal(info) {
        var event = info.event;

        document.querySelector('#event_id').value = event.id;
        document.querySelector('#editForm').action = document.querySelector('#editForm').action.replace('__id__', event.id);
        document.querySelector('#nameEdit').value = event.title;
        document.querySelector('#descriptionEdit').value = event.extendedProps.description;

        var eventColor = event.backgroundColor;

        var colorRadios = document.querySelectorAll('input[name="color"]');
        colorRadios.forEach(function (radio) {
            radio.checked = false;
        });

        var selectedRadio = document.querySelector('input[name="color"][value="' + eventColor + '"]');
        if (selectedRadio) {
            selectedRadio.checked = true;
        }

        var timezoneOffset = event.start.getTimezoneOffset();
        var originalStart = new Date(event.start.getTime() - timezoneOffset * 60000).toISOString().slice(0, 16);
        var originalEnd = new Date(event.end.getTime() - timezoneOffset * 60000).toISOString().slice(0, 16);

        document.querySelector('#startEdit').value = originalStart;
        document.querySelector('#endEdit').value = originalEnd;

        document.querySelector('#deleteForm').action = '/event/destroy/' + event.id;

        editEventModal.show();
    }

    document.getElementById('btnClose').addEventListener('click', function () {
        var eventModalElement = document.getElementById('editEventModal');
        var eventModal = Modal.getInstance(eventModalElement);
        if (eventModal) {
            eventModal.hide();
        }
    });
});
