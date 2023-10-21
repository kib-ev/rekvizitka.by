<?php

namespace App\Models;

use App\Traits\HasContractor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory, HasContractor;

    public function bank()
    {
        return $this->belongsTo(Contractor::class, 'bank_id', 'id');
    }
}
