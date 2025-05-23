<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';

    protected $primaryKey = 'bank_account_id';

    public $timestamps = false;

    protected $fillable = [
        
        'bank_code',
        'bank_name',
        'account_holder_name',
        'account_number',
    ];

   public function disbursement()
   {
       return $this->hasMany(Disbursements::class);
   }
    
}
