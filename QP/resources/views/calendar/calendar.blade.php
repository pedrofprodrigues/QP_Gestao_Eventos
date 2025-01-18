@extends('app')

@section('title', 'Calendar')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@event-calendar/build@3.8.0/event-calendar.min.css">
<script src="https://cdn.jsdelivr.net/npm/@event-calendar/build@3.8.0/event-calendar.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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
        calendar = new EventCalendar(calendarEl, {
            view: 'timeGridWeek',
            startWeekDay: 1,
            allDaySlot: false,
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                end: 'timeGridWeek,timeGridDay, resourceTimeGridDay',
            },
            resources:[
                {id:'JoaoIII' , title:'JoaoIII', eventBackgroundColor:'red'},
                {id:1 , title:'Maria', eventBackgroundColor:'blue'},
                {id:1 , title:'Francisco', eventBackgroundColor:'white'},
            ],
            slotDuration: 3600,
            minTime: '00:00',
            maxTime: '24:00',
            timeFormat:'HH:mm',
            events: events,
            eventClick: function(info) {
                var eventId = info.event.id;
                var editUrl = '/events/' + eventId + '/edit';
                window.open(editUrl, '_blank');
            },
        });
        
        flatpickr("#datePicker", {
           onChange: function (selectedDates) {
                calendar.setOption('date', selectedDates[0]); 
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
            console.log(event);
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
            if (event.backgroundColor === 'red') {
                (event.extendedProps.room || []).forEach(function(room) {
                    roomsToCheck.add(room);
                });
            }
        });

        console.log(roomsToCheck);

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
