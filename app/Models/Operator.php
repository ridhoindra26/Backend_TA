<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'status', 'username', 'password',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
