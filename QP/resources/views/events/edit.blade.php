@extends('app')


@section('title', 'Edit Event')


@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h1>Edit Event</h1>

<form id="eventForm" action="{{ route('events.update', $event->id) }}" method="POST" onsubmit="validateDates(event)">
    @csrf
    @method('PUT')
    <!-- Event Details -->
    <fieldset>
        <legend>Event Details</legend>
        <div class="mid">
            <label for="name">Event Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $event->name) }}" required>
        </div>
        <div class="form-group">
    <div class="mid">
        <label for="num_person">Number of Adults:</label>
        <input type="number" id="num_person" name="num_person"  value="{{ old('num_person', $event->num_person) }}" required>
    </div>
    <div class="mid">
        <label for="num_children">Number of Children:</label>
        <input type="number" id="num_children" name="num_children" value="{{ old('num_children', $event->num_children) }}" required>
    </div>
    <div class="mid">
        <label for="num_free_children">Number of Free Children:</label>
        <input type="number" id="num_free_children" name="num_free_children" value="{{ old('num_free_children', $event->num_free_children) }}" required>
    </div>
</div>

<div class="form-group">

<div class="mid">
        <label for="event_date_start">Event Start Date:</label>
        <input type="datetime-local" id="event_date_start" name="event_date_start" value="{{ old('event_date_start', $event->event_date_start->format('Y-m-d\TH:i')) }}" required>
    </div>
    <div class="mid">
        <label for="event_date_end">Event End Date:</label>
        <input type="datetime-local" id="event_date_end" name="event_date_end" value="{{ old('event_date_end', $event->event_date_end->format('Y-m-d\TH:i')) }}" required>
    </div>
    <div class="mid">
        <label for="event_type">Event Type:</label>
        <select id="event_type" name="event_type" required>
            @foreach($eventTypes as $eventType)
            <option value="{{ $eventType->id }}" {{ old('event_type', $event->event_type) == $eventType->id ? 'selected' : '' }}>{{ $eventType->option }}</option>
            @endforeach            
         </select>
        </div>
    </div>  
    </fieldset>

    <!-- Menu Selection -->
    <fieldset>
        <legend>Menu Selection</legend>
        @foreach($dishes as $dishName => $dishList)
        @php
            $dishNameLower = strtolower( rtrim($dishName, 's'));
        @endphp
    
        <div class="mid">
            <label for="{{ $dishNameLower }}">{{ ucfirst($dishNameLower) }}</label>
            <select id="{{ $dishNameLower }}" name="{{ $dishNameLower }}" required>
                @foreach($dishList as $singleDish)
                    <option value="{{ $singleDish->id }}" {{ old($dishNameLower, $event->{$dishNameLower}) == $singleDish->id ? 'selected' : '' }}>
                        {{ $singleDish->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endforeach


    </fieldset>

    <!-- Room Selection -->
    <fieldset>
        <legend>Room and Venue Selection</legend>
        <div class="checkbox-group">
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
            $auditoriumExtras = [
                'Stage' => 'stage',
                'Music' => 'auditorium_music',
            ];
            $lakeExtras = [
                'Firework' => 'fire',
                'Music' => 'lake_music',
            ];
            @endphp
    
            @foreach($rooms as $roomName => $roomVariable)
                <label>
                    <input type="hidden" name="{{ $roomVariable }}" value="off">
                    <input type="checkbox" id="{{ $roomVariable }}" name="{{ $roomVariable }}" value="on"
                    {{ $event->$roomVariable == true ? 'checked' : '' }} onclick="toggleExtras()"> {{ $roomName }}
                </label>
            @endforeach
        </div>
    
        <!-- Lago Extras Section -->
        <label for="lago_extras">Lago Extras:</label>
        @foreach($lakeExtras as $lakeExtra => $lakeVariable)
            <label>
                <input type="hidden" name="{{ $lakeVariable }}" value="off">
                <input type="checkbox" name="{{ $lakeVariable }}" value="on"
                {{ $event->$lakeVariable == true ? 'checked' : '' }}> {{ $lakeExtra }}
            </label>
        @endforeach
        <span><b>Other:</b></span>
        <textarea id="lago_extras" name="lago_extras"
            {{ $event->lago_extras ? '' : 'disabled' }}>
            {{ $event->lago_extras }}
        </textarea>
    
        <!-- Auditorio Extras Section -->
        <label for="auditorio_extras">Auditorio Extras:</label>
        @foreach($auditoriumExtras as $auditoriumExtra => $auditoriumVariable)
            <label>
                <input type="hidden" name="{{ $auditoriumVariable }}" value="off">
                <input type="checkbox" name="{{ $auditoriumVariable }}" value="on"
                {{ $event->$auditoriumVariable == true ? 'checked' : '' }}> {{ $auditoriumExtra }}
            </label>
        @endforeach
        <span><b>Other:</b></span>
        <textarea id="auditorio_extras" name="auditorio_extras">
            {{ $event->auditorio_extras }}
        </textarea>
    
        <!-- Jardim Extras Section -->
        <label for="jardim_extras">Jardim Extras:</label>
        <textarea id="jardim_extras" name="jardim_extras">
            {{ old('jardim_extras', $event->jardim_extras) }}
        </textarea>
    </fieldset>
    

    <!-- Other Details -->
    <fieldset>
        <legend>Additional Information</legend>
        <label for="decoration">Decoration:</label>  
        
        <input type="text" id="decoration" name="decoration" value="{{ old('decoration', $event->decoration) }}" required>

        <label for="entertainment">Entertainment:</label>
        <textarea id="entertainment" name="entertainment" required>{{ old('entertainment', $event->entertainment) }}</textarea>

        <label for="extras">Extras:</label>
        <textarea id="extras" name="extras" required>{{ old('extras', $event->extras) }}</textarea>
    </fieldset>

    <!-- Responsible Persons -->
    <fieldset>
        <legend>Contact Information</legend>

        <div class="form-group">
            <div class="mid">
                <label for="qp_resp_name">Quinta's Responsible Person:</label>
                <input type="text" id="qp_resp_name" name="qp_resp_name" value="{{ old('qp_resp_name', $event->qp_resp_name) }}" required>
            </div>
            <div class="mid">
                <label for="qp_resp_contact">Quinta's Contact Number:</label>
                <input type="text" id="qp_resp_contact" name="qp_resp_contact" value="{{ old('qp_resp_contact', $event->qp_resp_contact) }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="mid">
                <label for="client_resp_name">Client's Responsible Person:</label>
                <input type="text" id="client_resp_name" name="client_resp_name" value="{{ old('client_resp_name', $event->client_resp_name) }}" required>
            </div>
            <div class="mid">
                <label for="client_resp_contact">Client's Contact Number:</label>
                <input type="text" id="client_resp_contact" name="client_resp_contact" value="{{ old('client_resp_contact', $event->client_resp_contact) }}" required>
            </div>
            <div class="mid">
                <label for="client_resp_email">Client's Email:</label>
                <input type="email" id="client_resp_email" name="client_resp_email" value="{{ old('client_resp_email', $event->client_resp_email) }}" required>
            </div>
        </div>  
    </fieldset>

    <!-- Status -->
    <fieldset>
        <legend>Event Status</legend>
        <label for="status">Status:</label>
        <select id="current_status" name="current_status" required>
            @foreach($statuses as $status)
            <option value="{{ $status->id }}" {{ old('status', $event->current_status) == $status->id ? 'selected' : '' }}>{{ ucfirst($status->option) }}</option>
            @endforeach 
        </select>
    </fieldset>

    <button class="button-go" type="submit">Submit Event</button>
</form>



<script>
        function validateDates(event) {
            event.preventDefault();
            const startDate = new Date(document.getElementById('event_date_start').value);
            const endDate = new Date(document.getElementById('event_date_end').value);

            if (endDate <= startDate) {
                alert('End date must be after the start date.');
                return false;
            }

            document.getElementById('eventForm').submit();
        }


    function toggleExtras() {
        const lagoCheckbox = document.getElementById('lago');
        const lagoExtras = document.querySelectorAll('[name^="lake"], #lago_extras, [name^="fire"]');
       
        toggleFields(lagoCheckbox, lagoExtras);

        const auditorioCheckbox = document.getElementById('auditorio');
        const auditorioExtras = document.querySelectorAll('[name^="auditorium"], #auditorio_extras, [name^="stage"]');

        toggleFields(auditorioCheckbox, auditorioExtras);

        const jardimCheckbox = document.getElementById('jardim');
        const jardimExtras = document.querySelectorAll('#jardim_extras');

        toggleFields(jardimCheckbox, jardimExtras);
    }

    function toggleFields(checkbox, extras) {
        if (!checkbox.checked) {
            extras.forEach(function(element) {
                if (element.type === 'checkbox') {
                    element.checked = false;
                } else if (element.tagName.toLowerCase() === 'textarea' || element.type === 'text') {
                    element.value = '';
                }
                element.disabled = true;
            });
        } else {
            extras.forEach(function(element) {
                element.disabled = false;
            });
        }
    }


    window.onload = toggleExtras;

    document.getElementById('lago').addEventListener('change', toggleExtras);
    document.getElementById('auditorio').addEventListener('change', toggleExtras);
    document.getElementById('jardim').addEventListener('change', toggleExtras);
</script>


@endsection
