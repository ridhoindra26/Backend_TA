<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariantCategory extends Model
{
    use HasFactory;

    protected $table = 'menu_variant_category';

    protected $fillable = [
        'product_id', 'variant_category_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantCategory()
    {
        return $this->belongsTo(VariantCategory::class);
    }

}
