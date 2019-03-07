<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    public function users()
    {
    	return $this->belongsTo(\App\User::class,'employee_id');
    }
}
