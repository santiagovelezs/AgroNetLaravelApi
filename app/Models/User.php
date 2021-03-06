<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends UserRole
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'departamento',
        'ciudad',
        'telefono'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasType($role)
    {
        if($role == Role::REGISTERED_USER)
            return true;
        return parent::hasType($role);
    }

    public function admin()
    {       
        return $this->hasOne(Admin::class, 'id');
    }

    public function producer()
    {
        return $this->hasOne(Producer::class, 'id');
    }

    public function addrs()
    {
        return $this->hasMany(Addr::class, 'user_id');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'producer_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'user_id');
    }
}
