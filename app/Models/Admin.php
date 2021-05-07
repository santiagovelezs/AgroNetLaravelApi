<?php
use Illuminate\Support\Collection;
namespace App\Models;

class Admin extends User
{
    public function hasType($role)
    {       
        return true;        
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
