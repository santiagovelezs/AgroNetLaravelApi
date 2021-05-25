<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer_id',
        'category_id',
        'image_path',
        'name',
        'description',
        'measurement',
        'price'
    ];

    public function scopeOwnedBy($query, $producer_id)
    {
        return $query->where('producer_id', '=', $producer_id);
    }

    public function producers()
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }
}
