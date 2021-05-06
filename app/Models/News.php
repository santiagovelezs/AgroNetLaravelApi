<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [    
        'producer_id',
        'title',        
        'content'
    ];

    public function producer()
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }
}
