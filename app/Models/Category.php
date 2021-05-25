<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categorys";
    protected $fillable = [
        'category_name'
    ];

    public function categorys()
    {
        return $this->hasMany(Category::class, 'id');
    }

    
}
