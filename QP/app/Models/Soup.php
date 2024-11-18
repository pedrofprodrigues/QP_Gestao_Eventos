<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soup extends Model
{
    use HasFactory;
    protected $table = 'soups';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'details',
        'photo',

    ];
    public function events()
    {
        return $this->hasMany(Event::class, 'soup');
    }
}