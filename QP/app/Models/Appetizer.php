<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appetizer extends Model
{
    use HasFactory;
    protected $table = 'appetizers';
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
        return $this->hasMany(Event::class, 'appetizer');
    }
}
