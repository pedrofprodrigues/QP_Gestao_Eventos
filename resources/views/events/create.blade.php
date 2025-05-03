@extends('app')


@section('title', 'Novo Evento')


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
<h1>Novo Evento</h1>

<form id="eventForm" action="{{ route('events.store') }}" method="POST" onsubmit="validateDates(event)">
    @csrf
    <!-- Event Details -->
    <fieldset>
        <legend>Detalhes do Evento</legend>
        <div class="mid">
            <label for="name">Nome do Evento:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
    <div class="mid">
        <label for="num_person">Número de adultos (+10 anos):</label>
        <input type="number" id="num_person" name="num_person" required>
    </div>
    <div class="mid">
        <label for="num_children">Número de crianças (3 - 9 anos):</label>
        <input type="number" id="num_children" name="num_children" required>
    </div>
    <div class="mid">
        <label for="num_free_children">Número de bebés (0 - 2 anos):</label>
        <input type="number" id="num_free_children" name="num_free_children" required>
    </div>
</div>

<div class="form-group">

<div class="mid">
        <label for="event_date_start">Data de início</label>
        <input type="datetime-local" id="event_date_start" name="event_date_start" required>
    </div>
    <div class="mid">
        <label for="event_date_end">Data de fim:</label>
        <input type="datetime-local" id="event_date_end" name="event_date_end" required>
    </div>
    <div class="mid">
        <label for="event_type">Tipo de evento:</label>
        <select id="event_type" name="event_type" required>
            @foreach($eventTypes as $eventType)
            <option value="{{ $eventType->id }}">{{ $eventType->option }}</option>
            @endforeach             </select>
        </div>
    </div>  
    </fieldset>

    <!-- Menu Selection -->
    <fieldset>
        <legend>Selecionar Menu</legend>

<button class="button-go" onclick="openPopup()">Abrir escolha de menu para cliente</button>
@foreach($dishes as $dishData)
    @php
        $display = $dishData[0]; 
        $dishArray = collect($dishData)->except(0);
        $dishName = $dishArray->keys()->first();
        $dishList = $dishArray->first(); 
    @endphp

 
    <div class="mid">
        <label for="{{ $dishName }}">{{ $display }}</label>
        <select id="{{ $dishName }}" name="{{ $dishName }}">
            <option value=""> -- NA --</option>
                @foreach($dishList as $singleDish)
                    <option value="{{ $singleDish->id }}">{{ $singleDish->name }}</option>
                @endforeach
        </select>
    </div>
@endforeach

    </fieldset>

    <fieldset>
        <legend>Escolha de espaços</legend>
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
                'Jardim' => 'jardim',
                'Vip'=>'vip',
                'Vip2'=>'vip2'
            ];
            $auditoriumExtras = [
                'Palco' => 'stage',
                'Música' => 'auditorium_music',
            ];
            $lakeExtras = [
                'Fogo de artifício' => 'fire',
                'Música' => 'lake_music',
            ];
            @endphp
    
            @foreach($rooms as $roomName => $roomVariable)
                <label>
                    <input type="hidden" name="{{ $roomVariable }}" value="off">
                    <input type="checkbox" id="{{ $roomVariable }}" name="{{ $roomVariable }}" value="on" onclick="toggleExtras()"> {{ $roomName }}
                </label>
            @endforeach
        </div>
    
        <label for="lago_extras">Extras para Lago:</label>
        @foreach($lakeExtras as $lakeExtra => $lakeVariable)
            <label>
                <input type="hidden" name="{{ $lakeVariable }}" value="off">
                <input type="checkbox" name="{{ $lakeVariable }}" value="on"> {{ $lakeExtra }}
            </label>
        @endforeach
        <span><b>Outros:</b></span>
        <textarea id="lago_extras" name="lago_extras" disabled></textarea>
    
        <label for="auditorio_extras">Extras para Auditorio:</label>
        @foreach($auditoriumExtras as $auditoriumExtra => $auditoriumVariable)
            <label>
                <input type="hidden" name="{{ $auditoriumVariable }}" value="off">
                <input type="checkbox" name="{{ $auditoriumVariable }}" value="on"> {{ $auditoriumExtra }}
            </label>
        @endforeach
        <span><b>Outros:</b></span>
        <textarea id="auditorio_extras" name="auditorio_extras"></textarea>
        
        <label for="jardim_extras">Extras para Jardim:</label>
        <textarea id="jardim_extras" name="jardim_extras"></textarea>
    </fieldset>
    
  
    

    <!-- Other Details -->
    <fieldset>
        <legend>Informação adicional</legend>
        <label for="decoration">Decoração:</label>  
        
        <input type="text" id="decoration" name="decoration" required>

        <label for="entertainment">Entertenimento:</label>
        <textarea id="entertainment" name="entertainment" required></textarea>

        <label for="extras">Extras:</label>
        <textarea id="extras" name="extras" required></textarea>
    </fieldset>

    <!-- Responsible Persons -->
    <fieldset>
        <legend>Informações de contacto</legend>

        <div class="form-group">
    <div class="mid">
        <label for="qp_resp_name">Gestor responsável:</label>
        <input type="text" id="qp_resp_name" name="qp_resp_name" required>
    </div>
    <div class="mid">
        <label for="qp_resp_contact">Contacto do gestor:</label>
        <input type="text" id="qp_resp_contact" name="qp_resp_contact" required>
    </div>
</div>
<div class="form-group">
    <div class="mid">
        <label for="client_resp_name">Nome do cliente:</label>
        <input type="text" id="client_resp_name" name="client_resp_name" required>
    </div>
    <div class="mid">
        <label for="client_resp_contact">Contaco telefónico do cliente:</label>
        <input type="text" id="client_resp_contact" name="client_resp_contact" required>
    </div>
    <div class="mid">
        <label for="client_resp_email">Email do cliente:</label>
        <input type="email" id="client_resp_email" name="client_resp_email" required>
    </div>
</div>  
    </fieldset>

    <fieldset>
        <legend>Estado da reserva</legend>
        <label for="status">Status:</label>
        <select id="current_status" name="current_status" required>
            @foreach($statuses as $status)
            <option value="{{ $status->id }}">{{ ucfirst($status->option) }}</option>
        @endforeach 
        </select>
    </fieldset>

    <button class="button-go" type="submit">Gravar novo evento</button>
</form>



<script>
        
     function openPopup() {
                let popup = window.open("{{route('client')}}", "popupWindow", "width=1400,height=900");
            }

   function receiveValue(value) {
console.log(value);
            if (value[0]!=="none"){
                document.getElementById("appetizer").value = value[0];
            }
            if (value[1]!=="none"){
                document.getElementById("soup").value = value[1];
            }
            if (value[2]!=="none"){
                document.getElementById("fish").value = value[2];
            }
            if (value[3]!=="none"){
                document.getElementById("meat").value = value[3];
            }
            if (value[4]!=="none"){
                document.getElementById("dessert").value = value[4];
            }
        }
            
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
