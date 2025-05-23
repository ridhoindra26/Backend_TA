<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Disbursements extends Model
{
    use HasFactory;

    protected $table = 'disbursements';

    protected $fillable = [
        'admin_id',
        'external_id',
        'amount',
        'bank_account_id',
        'description',
        'period_start',
        'period_end',
        'status_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function status()
    {
        return $this->belongsTo(Statuses::class, 'status_id');
    }
}

