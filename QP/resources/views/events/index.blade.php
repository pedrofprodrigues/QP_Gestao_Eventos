@extends('app')

@section('title', 'Lista de eventos')

@section('content')
@if(session('success'))
<div class="custom-alert success-alert">
    {{ session('success') }}
    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
</div>
@endif

    <h1 class="mb-4">Lista de eventos</h1>

    <!-- Filters Form -->
    <form method="GET" action="{{ route('events.getAll') }}" class="mb-4">
        <div class="form-row">
            <div class="form-group">

                <div class="col-md-3">
                    <label for="event_name" class="form-label">Nome do evento:</label>
                    <input type="text" id="event_name" name="event_name" class="form-control" value="{{ request('event_name') }}" placeholder="Escreva nome do evento">
                </div>



            <div class="col-md-3">
                <label for="status" class="form-label">Estado da reserva:</label>
                <select id="status" name="status" class="form-control">
                    <option value="">Selecionar por estado de reserva</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ ucfirst($status->option) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="event_type" class="form-label">Tipo de evento:</label>
                <select id="event_type" name="event_type" class="form-control">
                    <option value="">Selecionar por tipo de evento</option>
                    @foreach($eventTypes as $eventType)
                        <option value="{{ $eventType->id }}" {{ request('event_type') == $eventType->id ? 'selected' : '' }}>
                            {{ ucfirst($eventType->option) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="event_date" class="form-label">Data de evento:</label>
                <input type="date" id="event_date" name="event_date" class="form-control" value="{{ request('event_date') }}">
            </div>


            
            <div class="col-md-3">
                <label for="show_deleted">Eventos apagados</label>
                <input type="checkbox" id="show_deleted" name="show_deleted" value="1" {{ request('show_deleted') ? 'checked' : '' }}>

            </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary ml-2">Filtrar</button>
            </div>

            <a href="{{ route('events.getAll') }}" class="btn btn-secondary ml-2">Limpar todos filtros</a>

        </div>
        </div>
    </form>

    <!-- Events Table -->
    @if($events->isEmpty())
        <p>Não há eventos marcados.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome do evento</th>
                    <th scope="col">Nº pessoas(A/C/B)</th>
                    <th scope="col">Salas</th>
                    <th scope="col">Data de início</th>
                    <th scope="col">Data do fim</th>
                    <th scope="col">Tipo de evento</th>
                    <th scope="col">Estado da reserva</th>
                    <th scope="col">Nome / Contacto do cliente</th>
                    <th scope="col">Gestor</th>
                    <th scope="col">Acções</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->num_person}} / {{ $event->num_children}} / {{$event->num_free_children }}</td>
                        <td>{{ $event->room_dinis ? 'Dinis' : '' }}
                            {{ $event->room_joaoiii ? 'JoaoIII' : '' }}
                            {{ $event->room_leonor ? 'Leonor' : '' }}
                            {{ $event->room_isabel ? 'Isabel' : '' }}
                            {{ $event->room_espelhos ? 'Espelhos' : '' }}
                            {{ $event->room_atrium ? 'Atrium' : '' }}
                            {{ $event->lago ? 'Lago' : '' }}
                            {{ $event->jardim ? 'Jardim' : '' }}
                            {{ $event->auditorio ? 'Auditorio' : '' }}
                        </td>
                        <td>{{ $event->event_date_start->format('j/m/Y, H:i') }}</td>
                        <td>{{ $event->event_date_end->format('j/m/Y, H:i') }}</td>

                        <td>{{ ucfirst($event->event_type_value->option) }}</td>
                        <td>{{ ucfirst($event->status_value->option) }}</td>
                        <td>{{ ucfirst($event->client_resp_name) }} / {{ $event->client_resp_contact }}</td>
                        <td>{{ ucfirst($event->qp_resp_name) }}</td>

                       <td>
                            <div class="form-group">
                                @if($event->deleted)
                                    <form action="{{ route('events.restore', ['id' => $event->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm" style="background-color:#8affad;" onclick="return confirm('Tem a certeza que quer restaurar o evento?');">Undelete</button>
                                    </form>
                                @else
                                <a href="{{ route('events.edit', ['id' => $event->id]) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('events.destroy', ['id' => $event->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem a certeza que quer apagar o evento?');">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                       
                   </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection
