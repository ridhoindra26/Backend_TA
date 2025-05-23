<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DisbursementStatuses extends Model
{
    use HasFactory;

    protected $table = 'disbursement_statuses';

    protected $fillable = [
        'title',
        'description',
    ];

    public function disbursement()
    {
        return $this->hasMany(Disbursements::class, 'status_id');
    }
    
}
