<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statuses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function orderLogs()
    {
        return $this->hasMany(OrderLogs::class);
    }

}
