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
}
