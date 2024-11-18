@extends('app')

@section('title', 'Event List')

@section('content')
@if(session('success'))
<div class="custom-alert success-alert">
    {{ session('success') }}
    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
</div>
@endif

    <h1 class="mb-4">All Events</h1>

    <!-- Filters Form -->
    <form method="GET" action="{{ route('events.getAll') }}" class="mb-4">
        <div class="form-row">
            <div class="form-group">

                <div class="col-md-3">
                    <label for="event_name" class="form-label">Event Name:</label>
                    <input type="text" id="event_name" name="event_name" class="form-control" value="{{ request('event_name') }}" placeholder="Search by name">
                </div>



            <div class="col-md-3">
                <label for="status" class="form-label">Status:</label>
                <select id="status" name="status" class="form-control">
                    <option value="">Select Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ ucfirst($status->option) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="event_type" class="form-label">Status:</label>
                <select id="event_type" name="event_type" class="form-control">
                    <option value="">Select Event Type</option>
                    @foreach($eventTypes as $eventType)
                        <option value="{{ $eventType->id }}" {{ request('event_type') == $eventType->id ? 'selected' : '' }}>
                            {{ ucfirst($eventType->option) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="event_date" class="form-label">Event Date:</label>
                <input type="date" id="event_date" name="event_date" class="form-control" value="{{ request('event_date') }}">
            </div>
            
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary ml-2">Filter</button>
            </div>

            <a href="{{ route('events.getAll') }}" class="btn btn-secondary ml-2">Clear Filters</a>

        </div>

        

          
        </div>
    </form>

    <!-- Events Table -->
    @if($events->isEmpty())
        <p>No events found.</p>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Event Name</th>
                    <th scope="col">Guests (A/C/FC)</th>
                    <th scope="col">Rooms</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Event Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Client</th>
                    <th scope="col">QP Manager</th>
                    <th scope="col">Actions</th>
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
                        <td>{{ ucfirst($event->client_resp_name) }} {{ $event->client_resp_contact }}</td>
                        <td>{{ ucfirst($event->qp_resp_name) }}</td>

                        <td>
                            <div class="form-group">
                                <a href="{{ route('events.edit', ['id' => $event->id]) }}" class="btn btn-secondary btn-sm">Edit</a>
                
                                <form action="{{ route('events.destroy', ['id' => $event->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?');">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection
