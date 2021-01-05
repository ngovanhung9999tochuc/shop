<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeRepository
{


    public function __construct()
    {
    }

    public function getHome()
    {
        $newProducts = Product::latest()->limit(8)->get();
        $phoneProducts = Product::where('id', 'like', 'DT%')->latest()->limit(8)->get();
        $laptopProducts = Product::where('id', 'like', 'LT%')->latest()->limit(8)->get();
        $tabletProducts = Product::where('id', 'like', 'TT%')->latest()->limit(8)->get();
        $slides = Slide::latest()->limit(4)->get();
        return ['newProducts' => $newProducts, 'phoneProducts' => $phoneProducts, 'laptopProducts' => $laptopProducts, 'tabletProducts' => $tabletProducts, 'slides' => $slides];
    }


    public function getPageTypeProduct($type, $id)
    {
        $productType = ProductType::where('key_code', $type)->get()[0];
        if ($productType->parent_id == 0) {
            $productTypes = ProductType::where('parent_id', $productType->id)->get();
            $products = Product::where('id', 'like', $type . '%')->paginate(12);
            return ['title' => $productType->name, 'productTypes' => $productTypes, 'products' => $products];
        } else {
            $productTypeParent = $productType->productTypeParent;
            $productTypes = ProductType::where('parent_id', $productTypeParent->id)->get();
            $products = Product::where('id', 'like', '__' . $type . '%')->paginate(12);
            return ['title' => $productType->name, 'productTypes' => $productTypes, 'products' => $products];
        }
    }

    public function getTypeProduct($id)
    {
        $productType = ProductType::find($id);
        $productTypeParent = $productType->productTypeParent;
        $productTypes = ProductType::where('parent_id', $productTypeParent->id)->get();
        $products = Product::where('product_type_id', $productType->id)->paginate(12);
        return ['title' => $productType->name, 'productTypes' => $productTypes, 'products' => $products];
    }

    public function getProductDetail($id)
    {
        $product = Product::find($id);
        $similarProduct = Product::where('product_type_id', $product->product_type_id)->limit(8)->get();
        $productType = $product->productType->productTypeParent;
        $productImage = $product->productImages;
        return ['product' => $product, 'similarProduct' => $similarProduct, 'productType' => $productType, 'productImage' => $productImage];
    }

    public function getOrder()
    {
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        return  [
            'items' => $cart->items,
            'totalPrice' => $cart->totalPrice,
            'totalQty' => $cart->totalQty,
        ];
    }

    public function search($request)
    {
    }
}
