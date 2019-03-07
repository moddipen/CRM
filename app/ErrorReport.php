<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorReport extends Model
{
    public function users()
    {
    	return $this->belongsTo(User::class,'updated_by');
    }
    public function errorsByUser()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
