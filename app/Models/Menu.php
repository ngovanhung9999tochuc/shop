<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function menuChildrent()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
