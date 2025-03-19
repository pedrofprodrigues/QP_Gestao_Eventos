<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Event::with([
            'event_type_value',
            'appetizer_value',
            'soup_value',
            'fish_value',
            'meat_value',
            'dessert_value',
            'status_value'
        ])->get()->map(function ($event) {
            return [
                'ID' => $event->id,
                'Name' => $event->name,
                'Num Persons' => $event->num_person,
                'Num Children' => $event->num_children,
                'Num Free Children' => $event->num_free_children,
                'Event Start' => $event->event_date_start,
                'Event End' => $event->event_date_end,
                'Event Type' => optional($event->event_type_value)->option,
                'Appetizer' => optional($event->appetizer_value)->name,
                'Soup' => optional($event->soup_value)->name,
                'Fish' => optional($event->fish_value)->name,
                'Meat' => optional($event->meat_value)->name,
                'Dessert' => optional($event->dessert_value)->name,
                'Room Dinis' => $event->room_dinis ? 't' : 'f',
                'Room Isabel' => $event->room_isabel ? 't' : 'f',
                'Room Joaoiii' => $event->room_joaoiii ? 't' : 'f',
                'Room Leonor' => $event->room_leonor ? 't' : 'f',
                'Room Espelhos' => $event->room_espelhos ? 't' : 'f',
                'Room Atrium' => $event->room_atrium ? 't' : 'f',
                'Lago' => $event->lago ? 't' : 'f',
                'Lago Extras' => $event->lago_extras,
                'Auditorio' => $event->auditorio ? 't' : 'f',
                'Auditorio Extras' => $event->auditorio_extras,
                'Jardim' => $event->jardim ? 't' : 'f',
                'Jardim Extras' => $event->jardim_extras,
                'Decoration' => $event->decoration,
                'Entertainment' => $event->entertainment,
                'Extras' => $event->extras,
                'QP Resp Name' => $event->qp_resp_name,
                'QP Resp Contact' => $event->qp_resp_contact,
                'Client Resp Name' => $event->client_resp_name,
                'Client Resp Contact' => $event->client_resp_contact,
                'Client Resp Email' => $event->client_resp_email,
                'Current Status' => optional($event->status_value)->option,
                'Fire' => $event->fire ? 'Yes' : 'No',
                'Lake Music' => $event->lake_music ? 'Yes' : 'No',
                'Auditorium Music' => $event->auditorium_music ? 'Yes' : 'No',
                'Stage' => $event->stage ? 'Yes' : 'No',
                'Collision IDs' => $event->collision_ids,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Convidados',
            'Criancas',
            'Criancinhas',
            'Inicio',
            'Fim',
            'Tipo',
            'Entradas',
            'Sopa',
            'Peixe',
            'Carne',
            'Sobremesa',
            'Room Dinis',
            'Room Isabel',
            'Room Joaoiii',
            'Room Leonor',
            'Room Espelhos',
            'Room Atrium',
            'Lago',
            'Lago Extras',
            'Auditorio',
            'Auditorio Extras',
            'Jardim',
            'Jardim Extras',
            'Decoration',
            'Entertainment',
            'Extras',
            'QP Resp Name',
            'QP Resp Contact',
            'Client Resp Name',
            'Client Resp Contact',
            'Client Resp Email',
            'Current Status',
            'Fire',
            'Lake Music',
            'Auditorium Music',
            'Stage',
            'Collision IDs',
        ];
    }
}
