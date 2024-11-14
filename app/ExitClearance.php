<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitClearance extends Model
{
    //
    public function signatories()
    {
        return $this->hasMany(ExitClearanceSignatory::class);
    }
    public function checklists()
    {
        return $this->hasMany(ExitClearanceChecklist::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function resign()
    {
        return $this->belongsTo(ExitResign::class);
    }
}
