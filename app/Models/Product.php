<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'description', 'photo', 'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function restaurant()
    // {
    //     return $this->belongsTo(Restaurant::class);
    // }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}
