@extends('app')

@section('title', 'Calendário')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@event-calendar/build@3.8.0/event-calendar.min.css">
<script src="https://cdn.jsdelivr.net/npm/@event-calendar/build@3.8.0/event-calendar.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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
        'Jardim' => 'jardim',
        'VIP' => 'vip',
        'VIP2' => 'vip2'
    ];
@endphp


    <div class="checkbox-group">
        @foreach($rooms as $room => $roomId)
            <label>
                <input type="checkbox" id="{{ $roomId }}" checked>{{ $room }}
            </label>
        @endforeach

        <div class="button-group">
            <button type="button" class="btn btn-secondary ml-2" onclick="checkAll()">Selecionar todas as salas</button>
            <button type="button" class="btn btn-secondary ml-2" onclick="uncheckAll()">Remover todas as salas</button>
            <button type="button" class="btn btn-primary ml-2" onclick="filterRedEvents()">Mostrar só eventos em conflito</button>
        </div>
    </div>
<input type="text" id="datePicker" placeholder="Seleccionar data" />

    <div class="calendar" id="calendar"></div>


<script>
    var events = JSON.parse(@json($formattedEventsJson));
    var calendar;

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        calendar = new EventCalendar(calendarEl, {
            view: 'timeGridWeek',
            startWeekDay: 1,
            eventTimeFormat: { hour: 'numeric', minute: '2-digit', hour12: false },
            slotLabelFormat: { hour: 'numeric', minute: '2-digit', hour12: false },
            titleFormat: function(date) {return date.toLocaleDateString('pt-PT', { month: 'long', day: 'numeric' });  },
            allDaySlot: false,
            buttonText:{resourceTimeGridDay: 'Vista diária', today:'Hoje', timeGridWeek:'Vista semanal'},
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                end: 'timeGridWeek, resourceTimeGridDay',
            },
            dayHeaderFormat: function(date) {return date.toLocaleDateString('pt-PT', { day: 'numeric',  weekday: 'long' });  },
            resources:[
                {id:1 , title:'Dinis', eventBackgroundColor:"#010669"},
                {id:2 , title:'Isabel', eventBackgroundColor:'#45012e'},
                {id:3 , title:'Joao III', eventBackgroundColor:'#069101'},
                {id:4 , title:'Leonor', eventBackgroundColor:'#000000'},
                {id:5 , title:'Espelhos', eventBackgroundColor:'#024200'},
                {id:6 , title:'Atrium', eventBackgroundColor:'#3492eb'},
                {id:7 , title:'Lago', eventBackgroundColor:'#4f4f4f'},
                {id:8 , title:'Auditorio', eventBackgroundColor:'#02b0a1'},
                {id:9 , title:'Jardim', eventBackgroundColor:'#362f7d'},
                {id:10 , title:'VIP', eventBackgroundColor:'#3285a8'},
                {id:11 , title:'VIP2', eventBackgroundColor:'#51693b'},
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

    var filteredEvents = events.filter(function (event) {
        var eventRooms = event.extendedProps.room || []; // Access event's room property
        return eventRooms.some(function (room) {
            return checkedRooms.includes(room);
        });
    });
    console.log(filteredEvents);
    calendar.setOption('events', filteredEvents);
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
