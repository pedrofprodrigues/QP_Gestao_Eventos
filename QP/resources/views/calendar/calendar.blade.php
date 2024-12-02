@extends('app')

@section('title', 'Calendar')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>

<input type="text" id="datePicker" placeholder="Select a date to change the week" />
@php
    $rooms = [
        'Dinis' => 'room_dinis',
        'Isabel' => 'room_isabel',
        'Joao III' => 'room_joaoiii',
        'Leonor' => 'room_leonor',
        'Espelhos' => 'room_espelhos',
        'Atrium' => 'room_atrium',
        'Lago' => 'lago',
        'Auditório' => 'auditorio',
        'Jardim' => 'jardim'
    ];
@endphp


    <div class="checkbox-group">
        @foreach($rooms as $room => $roomId)
            <label>
                <input type="checkbox" id="{{ $roomId }}" checked>{{ $room }}
            </label>
        @endforeach

        <div class="button-group">
            <button type="button" class="btn btn-secondary ml-2" onclick="checkAll()">Check All</button>
            <button type="button" class="btn btn-secondary ml-2" onclick="uncheckAll()">Uncheck All</button>
            <button type="button" class="btn btn-primary ml-2" onclick="filterRedEvents()">Show Collisions only</button>
        </div>
    </div>

    <div class="calendar" id="calendar"></div>


<script>
    var events = JSON.parse(@json($formattedEventsJson));
    var calendar;

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            firstDay: 1,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay',
            },
            slotDuration: '01:00:00',
            allDaySlot: false,
            slotMinTime: '00:00:00',
            slotMaxTime: '24:00:00',
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
            },
            events: events,
        eventClick: function(info) {
            var eventId = info.event.id;

            var editUrl = '/events/' + eventId + '/edit';
            window.open(editUrl, '_blank');
        },
        });

        calendar.render();

        flatpickr("#datePicker", {
            onChange: function (selectedDates) {
                calendar.gotoDate(selectedDates[0]);
            },
            defaultDate: new Date(),
        });

        document.querySelectorAll('.checkbox-group input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', filterEvents);
        });
    });

    function filterEvents() {
        var checkedRooms = [];
        document.querySelectorAll('.checkbox-group input[type="checkbox"]:checked').forEach(function (checkbox) {
            checkedRooms.push(checkbox.id);
        });

        calendar.getEvents().forEach(function (event) {
            var eventRooms = event.extendedProps.room || [];
            var showEvent = eventRooms.some(function (room) {
                return checkedRooms.includes(room);
            });

            event.setProp('display', showEvent ? 'auto' : 'none');
        });
    }

    function filterRedEvents() {
        var roomsToCheck = new Set();

        calendar.getEvents().forEach(function(event) {
            if (event.color === 'red') {
                (event.extendedProps.room || []).forEach(function(room) {
                    roomsToCheck.add(room);
                });
            }
        });

        document.querySelectorAll('.checkbox-group input[type="checkbox"]').forEach(function(checkbox) {
            var checkboxId = checkbox.id;
            var shouldCheck = roomsToCheck.has(checkboxId);
            checkbox.checked = shouldCheck;
        });

        filterEvents();
    }

    function checkAll() {
        document.querySelectorAll('.checkbox-group input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.checked = true;
        });
        filterEvents();
    }

    function uncheckAll() {
        document.querySelectorAll('.checkbox-group input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.checked = false;
        });
        filterEvents();
    }
</script>


<style>
    .calendar {
        display: flex;
        flex-direction: column;
        height: fit-content;
        flex-grow: 1;
        width: 100%;
    }


</style>

@endsection
