<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id')->withTimestamps();
    }

    public function premissions()
    {
        return $this->belongsToMany(Premission::class, 'premission_roles', 'role_id', 'permission_id')->withTimestamps();
    }

    
}
