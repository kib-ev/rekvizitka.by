<?php

namespace App\Models;

use App\Traits\HasContractor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory, HasContractor;
}
