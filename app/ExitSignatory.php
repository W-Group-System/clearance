<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitSignatory extends Model
{
    //
    function department()
    {
        return $this->belongsTo(Department::class);
    }
    function checklists()
    {
        return $this->hasMany(ExitChecklist::class);
    }
}
