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

    public function bills()
    {
        return $this->hasMany(Bill::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function ratings()
    {
        return $this->belongsToMany(Product::class, 'ratings', 'user_id', 'product_id')->withPivot('stars','text_rating')
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

    public function billins()
    {
        return $this->hasMany(BillIn::class, 'user_id');
    }

    public function checkCustomerRoleAccess()
    {
        $roles = auth()->user()->roles;
        if ($roles->count() == 0) {
            return false;
        } else if ($roles->count() == 1) {
            if ($roles[0]->id == 1) return false;
        }
        return true;
    }

    public function checkPermissionAccess($permissionKeyCode)
    {
        $roles = auth()->user()->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            if ($permissions->contains('key_code', $permissionKeyCode)) {
                return true;
            }
        }
        return false;
    }
}
