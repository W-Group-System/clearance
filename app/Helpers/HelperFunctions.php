<?php

use App\ExitClearanceSignatory;
use Carbon\Carbon;


function for_clearance()
{
    $for_clearances = ExitClearanceSignatory::with('clearance')
    ->where('employee_id',auth()->user()->employee->id)
    ->where('status','Pending')
->count();

    return $for_clearances;
}