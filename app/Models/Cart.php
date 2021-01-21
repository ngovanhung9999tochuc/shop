<?php

namespace App\Models;

class Cart
{
	public $items = null;
	public $totalQty = 0;
	public $totalPrice = 0;

	public function __construct($oldCart)
	{
		if ($oldCart) {
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}

	public function add($product)
	{
		$item = ['quantity' => 0, 'product' => $product];
		if ($this->items) {
			if (array_key_exists($product->id, $this->items)) {
				$item = $this->items[$product->id];
			}
		}
		if ($item['quantity'] < 10) {
			$item['quantity']++;
			$this->items[$product->id] = $item;
			$this->totalQuantity();
			$this->totalPrice();
		}
	}
	//tinh tong so luong
	public function totalQuantity()
	{
		$this->totalQty = 0;
		foreach ($this->items as  $item) {
			$this->totalQty += $item['quantity'];
		}
	}

	//tinh tong gia ban
	public function totalPrice()
	{
		$this->totalPrice = 0;
		foreach ($this->items as  $item) {
			$this->totalPrice += $item['quantity'] * ($item['product']->unit_price - $item['product']->unit_price * $item['product']->promotion_price / 100);
		}
	}

	//xóa 
	public function removeItem($id)
	{
		unset($this->items[$id]);
		$this->totalQuantity();
		$this->totalPrice();
	}
	//thay do so luong
	public function changeItem($id, $quantity)
	{
		if ($quantity > 0 && $quantity <= 10) {
			$this->items[$id]['quantity'] = $quantity;
			$this->totalQuantity();
			$this->totalPrice();
		}
	}
}
