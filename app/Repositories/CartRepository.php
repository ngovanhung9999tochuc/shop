<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class CartRepository
{

    protected $bill;
    protected $product;
    public function __construct(Bill $bill, Product $product)
    {
        $this->bill = $bill;
        $this->product = $product;
    }

    public function addItemToCart($request)
    {
        try {
            $product = Product::find($request->id);
            $oldCart = Session('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->add($product);
            $request->session()->put('cart', $cart);
            return response()->json(array('success' => true, 'item' => $cart->items[$product->id], 'totalQty' => $cart->totalQty, 'totalPrice' => $cart->totalPrice), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function changeQuantityItemToCart($request)
    {
        try {
            $product = Product::find($request->id);
            $oldCart = Session('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->changeItem($product->id, $request->quantity);
            $request->session()->put('cart', $cart);
            return response()->json(array('success' => true, 'item' => $cart->items[$product->id], 'totalQty' => $cart->totalQty, 'totalPrice' => $cart->totalPrice), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function deleteItemToCart($request)
    {
        try {
            $oldCart = Session('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->removeItem($request->id);
            $request->session()->put('cart', $cart);
            return response()->json(array('success' => true, 'id' => $request->id, 'totalQty' => $cart->totalQty, 'totalPrice' => $cart->totalPrice), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function destroy($id)
    {
    }

    public function search($request)
    {
    }
}
