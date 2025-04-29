<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'description', 'photo', 'price', 'status'
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

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariantCategory::class);
    }
}
