<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
	/**
	 * Display the cart page for customers.
	 */
	public function index(Request $request)
	{
		$cart = $request->session()->get('cart', []);

		$totalQuantity = array_sum(array_map(function ($item) {
			return (int) ($item['quantity'] ?? 0);
		}, $cart));

		$totalPrice = array_reduce($cart, function ($carry, $item) {
			$quantity = (int) ($item['quantity'] ?? 0);
			$price = (float) ($item['price'] ?? 0);
			return $carry + ($quantity * $price);
		}, 0.0);

		return view('customer.pages.cart', compact('cart', 'totalQuantity', 'totalPrice'));
	}

	/**
	 * Add a product to the cart (session-based).
	 */
	public function add(Request $request, Product $product)
	{
		$validated = $request->validate([
			'quantity' => 'nullable|integer|min:1',
		]);

		$quantityToAdd = max(1, (int) ($validated['quantity'] ?? 1));

		$cart = $request->session()->get('cart', []);
		$productId = $product->getKey();

		if (isset($cart[$productId])) {
			$existingQuantity = (int) ($cart[$productId]['quantity'] ?? 0);
			$cart[$productId]['quantity'] = $existingQuantity + $quantityToAdd;
		} else {
			$cart[$productId] = [
				'id' => $productId,
				'name' => $product->name,
				'price' => $product->price,
				'image' => $product->image ?? '/images/default-product.svg',
				'quantity' => $quantityToAdd,
			];
		}

		$request->session()->put('cart', $cart);

		return back()->with('success', __('Product added to cart.'));
	}

	/**
	 * Update the quantity of a cart item.
	 */
	public function update(Request $request, Product $product)
	{
		$validated = $request->validate([
			'quantity' => 'required|integer|min:0',
		]);

		$newQuantity = (int) $validated['quantity'];
		$cart = $request->session()->get('cart', []);
		$productId = $product->getKey();

		if ($newQuantity <= 0) {
			unset($cart[$productId]);
		} else {
			if (isset($cart[$productId])) {
				$cart[$productId]['quantity'] = $newQuantity;
			}
		}

		$request->session()->put('cart', $cart);

		return back()->with('success', __('Cart updated.'));
	}

	/**
	 * Remove a product from the cart.
	 */
	public function remove(Request $request, Product $product)
	{
		$cart = $request->session()->get('cart', []);
		$productId = $product->getKey();
		unset($cart[$productId]);
		$request->session()->put('cart', $cart);

		return back()->with('success', __('Product removed from cart.'));
	}

	/**
	 * Clear all items in the cart.
	 */
	public function clear(Request $request)
	{
		$request->session()->forget('cart');
		return back()->with('success', __('Cart cleared.'));
	}
} 
