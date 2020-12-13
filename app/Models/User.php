<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function Bills()
    {
        return $this->hasMany(Bill::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function ratings()
    {
        return $this->belongsToMany(Product::class, 'ratings', 'user_id', 'product_id')->withPivot('stars')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->belongsToMany(Product::class, 'comments', 'user_id', 'product_id')->withPivot('content', 'parent_id')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')->withTimestamps();
    }
}
