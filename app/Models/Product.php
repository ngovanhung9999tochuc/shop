<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'specifications' => 'array'
    ];
    public $incrementing = false;
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
        return $this->belongsToMany(User::class, 'ratings', 'product_id', 'user_id')->withPivot('stars', 'text_rating')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments', 'product_id', 'user_id')->withPivot('content', 'parent_id')
            ->withTimestamps();
    }

    public function userReview()
    {
        return $this->hasOne(UserReview::class, 'product_id');
    }

    public function userReview1()
    {
        $result = null;
        $userReview = DB::select('select r.product_id AS product_id,sum(r.stars) / count(r.product_id) AS average,count(r.product_id) AS quantity_rating from ratings r group by r.product_id');
        $reviews = collect($userReview);
        if ($reviews->contains('product_id', $this->id)) {
            foreach ($reviews as $review) {
                if ($review->product_id == $this->id) {
                    $result = $review;
                    break;
                }
            }
        }
        return $result;
    }
}
