<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExitResign extends Model
{
    use SoftDeletes;
    
    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function Company()
    {
        return $this->belongsTo(Company::class);
    }
    public function Department()
    {
        return $this->belongsTo(Department::class);
    }
    public function exit_clearance()
    {
        return $this->hasMany(ExitClearance::class,'resign_id','id');
    }
}
