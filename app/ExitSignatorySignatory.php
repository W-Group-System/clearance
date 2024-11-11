<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitSignatorySignatory extends Model
{
    //

    function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
