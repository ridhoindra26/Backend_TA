<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'status', 'xendit_id', 'total_price', 'payment_method', 'admin_id', 'operator_id', 'drone_id', 'station_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function drone()
    {
        return $this->belongsTo(Drone::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}
