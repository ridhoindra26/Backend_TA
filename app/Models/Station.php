<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'longitude', 'latitude', 'name',
    ];

    public function drones()
    {
        return $this->hasMany(Drone::class);
    }
}
