<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meat extends Model
{
    use HasFactory;
    protected $table = 'meats';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'details',
        'photo',
        'galery',

    ];
    public function events()
    {
        return $this->hasMany(Event::class, 'meat');
    }
}
