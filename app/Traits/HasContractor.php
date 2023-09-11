<?php

namespace App\Traits;

use App\Models\Contractor;

trait HasContractor
{
    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
