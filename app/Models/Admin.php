<?php
use Illuminate\Support\Collection;
namespace App\Models;

class Admin extends RegisteredUser
{
    public function hasType($role)
    {       
        return true;        
    }

    public function owner()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }
}
