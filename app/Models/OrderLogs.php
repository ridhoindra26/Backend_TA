<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderLogs extends Model
{
    use HasFactory;

    protected $table = 'delivery_logs';

    protected $fillable = [
        'transaction_id', 'status_id','notes'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function status()
    {
        return $this->belongsTo(Statuses::class);
    }

}
