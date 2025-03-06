<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Drone extends Model
{
    use HasFactory;

    protected $fillable = [
        'longitude', 'latitude', 'altitude', 'ground_speed', 'vertical_speed', 'distance', 'battery', 'link_quality', 'GPSStat',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
