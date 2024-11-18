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
    @forEach($rooms as $room=>$roomId)
    <label> <input type="checkbox" id={{$roomId}} checked>{{$room}} </label>
    @endforeach

    <div class="col-md-3 align-self-end">
        <button type="button" class="btn btn-secondary ml-2" onclick="checkAll()">Check All</button>
        <button type="button" class="btn btn-secondary ml-2" onclick="uncheckAll()">Uncheck All</button>
        <button type="button" class="btn btn-primary ml-2" onclick="filterRedEvents()">Show Collisions only</button>

    </div>

</div>
<div class='calendar' id="calendar"></div>

<script>
    var events = JSON.parse(@json($formattedEventsJson));
    var calendar;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            eventClick: function(info) {
                var eventObj = info.event;
                window.open("http://127.0.0.1:8000/events/"+eventObj.id+"/edit");              
            },
            initialView: 'timeGridWeek',
            slotDuration: '01:00:00',
            allDaySlot: false,
            slotMinTime: '00:00:00',
            slotMaxTime: '24:00:00',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            events: events,

            eventContent: function(info) {
    var title = info.event.title;
    var description = info.event.extendedProps.description;
    var location = info.event.extendedProps.location;

    // Create a custom HTML structure
    var innerHtml = `
      <div class="fc-event-title">${title}</div>
      <div class="fc-event-desc">${description}</div>
    `;

    // Return an array of elements for the event
    return { html: innerHtml };
  }
        });

        calendar.render();

        // Add event listeners for each checkbox
        document.querySelectorAll('.checkbox-group input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', filterEvents);
        });

        flatpickr("#datePicker", {
            onChange: function(selectedDates) {
                var selectedDate = selectedDates[0];
                calendar.gotoDate(selectedDate);
            },
            defaultDate: new Date(),
        });
    });

    function filterEvents() {
        var checkedRooms = [
            'room_dinis',
            'room_isabel',
            'room_joaoiii',
            'room_leonor',
            'room_espelhos',
            'room_atrium',
            'lago',
            'jardim',
            'auditorio'
        ].filter(function(roomId) {
            return document.getElementById(roomId).checked;
        });

        console.log('Checked Rooms:', checkedRooms);

        calendar.getEvents().forEach(function(event) {
            console.log('Event:', event);
            var eventRooms = event.extendedProps.room || [];
            console.log('Event Rooms:', eventRooms);

            
            var showEvent = eventRooms.some(function(room) {
                return checkedRooms.includes(room);
            });

            console.log('Show Event:', showEvent);
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

@endsection
