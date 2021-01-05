<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'email',
        'address',
        'phone',
        'date_order',
        'complete_order',
        'total',
        'quantity',
        'payment',
        'status',
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'bill_details')->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
