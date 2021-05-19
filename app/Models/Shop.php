<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer_id',
        'whatsapp',
        'phone',
        'email',
        'addr_id',
        'price_per_km',
        'max_shipping_distance'
    ];

    public function owner()
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }

    public function addr()
    {
        return $this->belongsTo(Addr::class, 'addr_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
