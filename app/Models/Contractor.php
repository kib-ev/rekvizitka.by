<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'exclude_date' => 'datetime'
    ];

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}
