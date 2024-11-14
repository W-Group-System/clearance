<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitClearanceSignatory extends Model
{
    //
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function clearance()
    {
        return $this->belongsTo(ExitClearance::class,'exit_clearance_id','id');
    }
}
