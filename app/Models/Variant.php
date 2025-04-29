<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_category_id', 'name', 'price', 'status',
    ];

    public function variantCategory()
    {
        return $this->belongsTo(VariantCategory::class);
    }

}
