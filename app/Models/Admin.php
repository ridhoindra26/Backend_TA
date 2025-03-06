<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'username', 'password',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
