<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransactionVariant extends Model
{
    use HasFactory;

    protected $table = 'detail_transaction_variant';

    protected $fillable = [
        'detail_transaction_id', 'variant_category', 'variant_name', 'price',
    ];

    public function detailTransaction()
    {
        return $this->belongsTo(DetailTransaction::class);
    }

}
