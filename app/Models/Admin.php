<?php
use Illuminate\Support\Collection;
namespace App\Models;

class Admin extends User
{
    protected $primaryKey = 'id';

    public $incrementing = false;
    
    public function hasType($role)
    {       
        return true;        
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
