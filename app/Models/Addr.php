<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addr extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'province',
        'city',
        'street',
        'location',
        'etiqueta',
        'user_id'
    ];

    public function scopeOwnedBy($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function geoLocation()
    {
        return $this->hasOne(GeoLocation::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
