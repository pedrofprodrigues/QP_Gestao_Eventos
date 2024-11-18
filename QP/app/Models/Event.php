<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'num_person',
        'num_children',
        'num_free_children',
        'event_date_start',
        'event_date_end',
        'event_type',
        'appetizer',
        'soup',
        'fish',
        'meat',
        'dessert',
        'room_dinis',
        'room_isabel',
        'room_joaoiii',
        'room_leonor',
        'room_espelhos',
        'room_atrium',
        'lago',
        'lago_extras',
        'auditorio',
        'auditorio_extras',
        'jardim',
        'jardim_extras',
        'decoration',
        'entertainment',
        'extras',
        'qp_resp_name',
        'qp_resp_contact',
        'client_resp_name',
        'client_resp_contact',
        'client_resp_email',
        'current_status',
        'fire',
        'lake_music',
        'auditorium_music',
        'stage',
        'collision_ids'
    ];

    protected $casts = [
        'event_date_start' => 'datetime',
        'event_date_end' => 'datetime',
    ];

    protected $attributes = [
        'fire' => false,
        'lake_music' => false,
        'auditorium_music' => false,
        'stage' => false,
        'deleted' => false,
    ];

    public function event_type_value()
    {
        return $this->belongsTo(EventType::class, 'event_type');
    }

    public function appetizer_value()
    {
        return $this->belongsTo(Appetizer::class, 'appetizer');
    }

    public function soup_value()
    {
        return $this->belongsTo(Soup::class, 'soup');
    }

    public function fish_value()
    {
        return $this->belongsTo(Fish::class, 'fish');
    }

    public function meat_value()
    {
        return $this->belongsTo(Meat::class, 'meat');
    }

    public function dessert_value()
    {
        return $this->belongsTo(Dessert::class, 'dessert');
    }

    public function status_value()
    {
        return $this->belongsTo(Status::class, 'current_status');
    }
}
