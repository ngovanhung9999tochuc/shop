<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillIn extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bill_in_details', 'bill_in_id', 'product_id')->withPivot('quantity', 'original_price')
            ->withTimestamps();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
