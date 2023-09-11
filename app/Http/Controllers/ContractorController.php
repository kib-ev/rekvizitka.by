<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function update(Request $request, Contractor $contractor)
    {
        $contractor->fill($request->all());
        $contractor->update();

        return back();
    }
}
