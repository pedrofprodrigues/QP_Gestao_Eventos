<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;
    protected $table = 'event_types';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'option',

    ];
    public function events()
    {
        return $this->hasMany(Event::class, 'option');
    }
}
