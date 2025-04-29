<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariantCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'min_selection', 'max_selection',
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function productVariantCategories()
    {
        return $this->hasMany(ProductVariantCategory::class);
    }

}
