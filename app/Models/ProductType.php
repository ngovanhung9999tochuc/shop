<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id');
    }

    public function productTypeChildrent()
    {
        return $this->hasMany(ProductType::class, 'parent_id');
    }
}
