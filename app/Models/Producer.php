<?php
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

namespace App\Models;

class Producer extends User
{
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [

        'id'               
    ];

    public function hasType($role)
    {
        if($role == Role::REGISTERED_USER)
            return true;
        if($role == Role::PRODUCER)
            return true;
        return parent::hasType($role);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function news()
    {
        return $this->hasMany(News::class, 'producer_id');
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
