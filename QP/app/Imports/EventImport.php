<?php

namespace App\Imports;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Appetizer;
use App\Models\Soup;
use App\Models\Fish;
use App\Models\Meat;
use App\Models\Dessert;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class EventImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Event([
            'name' => $row['nome'],
            'num_person' => $row['convidados'],
            'num_children' => $row['criancas'],
            'num_free_children' => $row['criancinhas'],
            'event_date_start' => Carbon::createFromFormat('Y-m-d H:i:s', $row['inicio']),
            'event_date_end' => Carbon::createFromFormat('Y-m-d H:i:s', $row['fim']),
            'event_type' => EventType::where('option', $row['tipo'])->value('id'),
            'appetizer' => Appetizer::where('name', $row['entradas'])->value('id'),
            'soup' => Soup::where('name', $row['sopa'])->value('id'),
            'fish' => Fish::where('name', $row['peixe'])->value('id'),
            'meat' => Meat::where('name', $row['carne'])->value('id'),
            'dessert' => Dessert::where('name', $row['sobremesa'])->value('id'),
            'room_dinis' => $row['room_dinis'],
            'room_isabel' => $row['room_isabel'],
            'room_joaoiii' => $row['room_joaoiii'],
            'room_leonor' => $row['room_leonor'],
            'room_espelhos' => $row['room_espelhos'],
            'room_atrium' => $row['room_atrium'],
            'lago' => $row['lago'],
            'lago_extras' => $row['lago_extras'],
            'auditorio' => $row['auditorio'],
            'auditorio_extras' => $row['auditorio_extras'],
            'jardim' => $row['jardim'],
            'jardim_extras' => $row['jardim_extras'],
            'decoration' => $row['decoration'],
            'entertainment' => $row['entertainment'],
            'extras' => $row['extras'],
            'qp_resp_name' => $row['qp_resp_name'],
            'qp_resp_contact' => $row['qp_resp_contact'],
            'client_resp_name' => $row['client_resp_name'],
            'client_resp_contact' => $row['client_resp_contact'],
            'client_resp_email' => $row['client_resp_email'],
            'current_status' => Status::where('option', $row['current_status'])->value('id'),
            'fire' => strtolower($row['fire']) === 'yes',
            'lake_music' => strtolower($row['lake_music']) === 'yes',
            'auditorium_music' => strtolower($row['auditorium_music']) === 'yes',
            'stage' => strtolower($row['stage']) === 'yes',
            'collision_ids' => $row['collision_ids'],
        ]);
    }
}
