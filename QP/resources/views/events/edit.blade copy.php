@extends('app')

@section('title', 'Edit Event')

@section('content')
<h1>Edit Event</h1>

<form action="{{ route('events.update', $event->id) }}" method="POST">
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
                <input type="number" id="num_person" name="num_person" value="{{ old('num_person', $event->num_person) }}" required>
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
                        <option value="{{ $eventType->id }}" {{ old('event_type', $event->event_type) == $eventType->id ? 'selected' : '' }}>{{ $eventType->event_type }}</option>
                    @endforeach
                </select>
            </div>
        </div>  
    </fieldset>

    <!-- Menu Selection -->
    <fieldset>
        <legend>Menu Selection</legend>

        <div class="mid">
            <label for="appetizer">Appetizer:</label>
            <select id="appetizer" name="appetizer" required>
                @foreach($appetizers as $appetizer)
                    <option value="{{ $appetizer->id }}" {{ old('appetizer', $event->appetizer) == $appetizer->id ? 'selected' : '' }}>{{ $appetizer->name }}</option>
                @endforeach       
            </select>
        </div>
        <div class="mid">
            <label for="soup">Soup:</label>
            <select id="soup" name="soup" required>
                @foreach($soups as $soup)
                    <option value="{{ $soup->id }}" {{ old('soup', $event->soup) == $soup->id ? 'selected' : '' }}>{{ $soup->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mid">
            <label for="fish">Fish:</label>
            <select id="fish" name="fish" required>
                @foreach($fishs as $fish)
                    <option value="{{ $fish->id }}" {{ old('fish', $event->fish) == $fish->id ? 'selected' : '' }}>{{ $fish->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mid">
            <label for="meat">Meat:</label>
            <select id="meat" name="meat" required>
                @foreach($meats as $meat)
                    <option value="{{ $meat->id }}" {{ old('meat', $event->meat) == $meat->id ? 'selected' : '' }}>{{ $meat->name }}</option>
                @endforeach        
            </select>
        </div>
        <div class="mid">
            <label for="dessert">Dessert:</label>
            <select id="dessert" name="dessert" required>
                @foreach($desserts as $dessert)
                    <option value="{{ $dessert->id }}" {{ old('dessert', $event->dessert) == $dessert->id ? 'selected' : '' }}>{{ $dessert->name }}</option>
                @endforeach       
            </select>
        </div>
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
        @endphp
            @foreach($rooms as $roomName => $roomDB)
                <label>
                    <input type="hidden" name="{{ $roomDB }}" value="off">
                    <input type="checkbox" name="{{ $roomDB }}" value="on" {{ old($roomDB, $event->$roomDB) == 'on' ? 'checked' : 'off' }}> {{ ucfirst($roomName) }}
                </label>
            @endforeach
        </div>
        <label for="lago_extras">Lago Extras:</label>
        <textarea id="lago_extras" name="lago_extras">{{ old('lago_extras', $event->lago_extras) }}</textarea>

        <label for="auditorio_extras">Auditorio Extras:</label>
        <textarea id="auditorio_extras" name="auditorio_extras">{{ old('auditorio_extras', $event->auditorio_extras) }}</textarea>

        <label for="jardim_extras">Jardim Extras:</label>
        <textarea id="jardim_extras" name="jardim_extras">{{ old('jardim_extras', $event->jardim_extras) }}</textarea>
    </fieldset>


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
                    <input type="checkbox" name="{{ $roomVariable }}" value="on" {{ old($roomVariable, $event->$roomVariable) == 'on' ? 'checked' : 'off' }} onclick="toggleExtras()"> {{ ucfirst($roomName) }}
                </label>
            @endforeach
        </div>
    
        <label for="lago_extras">Lago Extras:</label>
        @foreach($lakeExtras as $lakeExtra => $lakeVariable)
            <label>
                <input type="hidden" name="{{ $lakeVariable }}" value="off">
                <input type="checkbox" name="{{ $lakeVariable }}" value="on"> {{ $lakeExtra }}
            </label>
        @endforeach
        <span><b>Other:</b></span>
        <textarea id="lago_extras" name="lago_extras" disabled></textarea>
    
        <label for="auditorio_extras">Auditorio Extras:</label>
        @foreach($auditoriumExtras as $auditoriumExtra => $auditoriumVariable)
            <label>
                <input type="hidden" name="{{ $auditoriumVariable }}" value="off">
                <input type="checkbox" name="{{ $auditoriumVariable }}" value="on"> {{ $auditoriumExtra }}
            </label>
        @endforeach
        <span><b>Other:</b></span>
        <textarea id="auditorio_extras" name="auditorio_extras"></textarea>
        
        <label for="jardim_extras">Jardim Extras:</label>
        <textarea id="jardim_extras" name="jardim_extras"></textarea>
    </fieldset>
    







    <!-- Other Details -->
    <fieldset>
        <legend>Additional Information</legend>
        <label for="decoration">Decoration:</label>
        <input type="text" id="decoration" name="decoration" value="{{ old('decoration', $event->decoration) }}" required>

        <label for="entertainment">Entertainment:</label>
        <textarea id="entertainment" name="entertainment">{{ old('entertainment', $event->entertainment) }}</textarea>

        <label for="extras">Extras:</label>
        <textarea id="extras" name="extras">{{ old('extras', $event->extras) }}</textarea>
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
        <select id="status" name="status" required>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}" {{ old('status', $event->status) == $status->id ? 'selected' : '' }}>{{ ucfirst($status->status) }}</option>
            @endforeach 
        </select>
    </fieldset>
    <input type="hidden" id="{{$info_detail->id}}" name="id" required value="{{$info_detail->id}}" > 

    <button class="button-go" type="submit">Update Event</button>
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
