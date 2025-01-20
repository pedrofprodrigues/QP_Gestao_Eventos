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
                

            $roomMappings = [
                'room_dinis' => ['Dinis', '1'],
                'room_isabel' => ['Isabel', '2'],
                'room_joaoiii' => ['JoaoIII', '3'],
                'room_leonor' => ['Leonor', '4'],
                'room_espelhos' => ['Espelhos', '5'],
                'room_atrium' => ['Atrium', '6'],
                'lago' => ['Lago', '7'],
                'auditorio' => ['Auditorio', '8'],
                'jardim' => ['Jardim', '9'],
            ];

            $roomsUsed = [];
            $rooms = [];
            $resourceId = [];

            foreach ($roomMappings as $attribute => [$name, $id]) {
                if ($event->$attribute) {
                    $roomsUsed[] = $name;
                    $rooms[] = $attribute;
                    $resourceId[] = $id; 
                }
            }

            $roomsUsedString = implode("\n", $roomsUsed);

            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->event_date_start->format('Y-m-d\TH:i:s'),
                'end' => $event->event_date_end->format('Y-m-d\TH:i:s'),
                'color' => $hasCollision ? 'red' : null,
                'textColor' => $hasCollision ? 'black' : null,
                'resourceId' => $resourceId,
                'extendedProps' => [
                    'roomsUsed' => $roomsUsedString,
                    'room' => $rooms,
                ],
            ];
        });

        $formattedEventsJson = json_encode($formattedEvents);


        return view('calendar.calendar', compact('formattedEventsJson'));
    }
}
