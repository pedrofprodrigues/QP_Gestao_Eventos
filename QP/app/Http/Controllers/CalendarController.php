<?php

namespace App\Http\Controllers;

use App\Models\Event;

class CalendarController extends Controller
{
    public function show()
    {
        $events = Event::where('deleted', false)->get();

        $formattedEvents = $events->map(function ($event) {

            $existingCollisionIds = json_decode($event->collision_ids, true) ?? [];
            $hasCollision = count($existingCollisionIds) > 0;


            $roomsUsed = [];

            if ($event->room_dinis) $roomsUsed[] = 'Dinis';
            if ($event->room_isabel) $roomsUsed[] = 'Isabel';
            if ($event->room_joaoiii) $roomsUsed[] = 'JoaoIII';
            if ($event->room_leonor) $roomsUsed[] = 'Leonor';
            if ($event->room_espelhos) $roomsUsed[] = 'Espelhos';
            if ($event->room_atrium) $roomsUsed[] = 'Atrium';
            if ($event->lago) $roomsUsed[] = 'Lago';
            if ($event->auditorio) $roomsUsed[] = 'Auditorio';
            if ($event->jardim) $roomsUsed[] = 'Jardim';

            $roomsUsedString = implode("\n", $roomsUsed);

            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->event_date_start->format('Y-m-d\TH:i:s'),
                'end' => $event->event_date_end->format('Y-m-d\TH:i:s'),
                'room' => $roomsUsed,
                'color' => $hasCollision ? 'red' : null,
                'textColor' => $hasCollision ? 'black' : null,
                'extendedProps' => [
                    'description' => $roomsUsedString
                ],
            ];
        });

        $formattedEventsJson = json_encode($formattedEvents);


        return view('calendar.calendar', compact('formattedEventsJson'));
    }
}
