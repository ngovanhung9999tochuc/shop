<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'specifications' => 'array'
    ];

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_details')->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function billIns()
    {
        return $this->belongsToMany(BillIn::class, 'bill_in_details', 'product_id', 'bill_in_id')->withPivot('quantity', 'original_price')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratings()
    {
        return $this->belongsToMany(User::class, 'ratings', 'product_id', 'user_id')->withPivot('stars')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments', 'product_id', 'user_id')->withPivot('content','parent_id')
            ->withTimestamps();
    }
}
