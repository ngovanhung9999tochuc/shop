<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Premission extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'premission_roles', 'permission_id', 'role_id')->withTimestamps();
    }

    public function premissionChildrent()
    {
        return $this->hasMany(Premission::class, 'parent_id');
    }
}
