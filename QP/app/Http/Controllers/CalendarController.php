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
            $rooms = [];

            if ($event->room_dinis) {
                $roomsUsed[] = 'Dinis';
                $rooms[] = 'room_dinis';
            }
            if ($event->room_isabel) {
                $roomsUsed[] = 'Isabel';
                $rooms[] = 'room_isabel';
            }
            if ($event->room_joaoiii) {
                $roomsUsed[] = 'JoaoIII';
                $rooms[] = 'room_joaoiii';
            }
            if ($event->room_leonor) {
                $roomsUsed[] = 'Leonor';
                $rooms[] = 'room_leonor';
            }
            if ($event->room_espelhos) {
                $roomsUsed[] = 'Espelhos';
                $rooms[] = 'room_espelhos';
            }
            if ($event->room_atrium) {
                $roomsUsed[] = 'Atrium';
                $rooms[] = 'room_atrium';
            }
            if ($event->lago) {
                $roomsUsed[] = 'Lago';
                $rooms[] = 'lago';
            }
            if ($event->auditorio) {
                $roomsUsed[] = 'Auditorio';
                $rooms[] = 'auditorio';
            }
            if ($event->jardim) {
                $roomsUsed[] = 'Jardim';
                $rooms[] = 'jardim';
            }


            $roomsUsedString = implode("\n", $roomsUsed);

            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->event_date_start->format('Y-m-d\TH:i:s'),
                'end' => $event->event_date_end->format('Y-m-d\TH:i:s'),
                'room' => $rooms,
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
