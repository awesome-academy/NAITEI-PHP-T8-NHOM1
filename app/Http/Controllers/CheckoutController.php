<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page with cart summary
     */
    public function create(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('customer.cart.index')->with('success', __('Your cart is empty.'));
        }

        $totalQuantity = array_sum(array_map(function ($item) {
            return (int) ($item['quantity'] ?? 0);
        }, $cart));

        $totalPrice = array_reduce($cart, function ($carry, $item) {
            $quantity = (int) ($item['quantity'] ?? 0);
            $price = (float) ($item['price'] ?? 0);
            return $carry + ($quantity * $price);
        }, 0.0);

        return view('customer.pages.checkout', compact('cart', 'totalQuantity', 'totalPrice'));
    }

    /**
     * Place order from session cart
     */
    public function store(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('customer.cart.index')->with('info', __('Your cart is empty.'));
        }

        $productIds = array_map('intval', array_keys($cart));

        // Load products keyed by primary key (product_id)
        $products = Product::whereIn('product_id', $productIds)->get()->keyBy('product_id');

        // Validate all items exist and have sufficient stock
        $computedTotal = 0.0;
        foreach ($cart as $pid => $item) {
            $pid = (int) $pid;
            $product = $products[$pid] ?? null;
            if (!$product) {
                return back()->with('error', __('A product in your cart is no longer available.'));
            }
            $quantity = (int) ($item['quantity'] ?? 0);
            if ($quantity <= 0) {
                return back()->with('error', __('Invalid item quantity in cart.'));
            }
            if (isset($product->stock) && $product->stock !== null && $product->stock < $quantity) {
                return back()->with('error', __('Insufficient stock for product: ') . $product->name);
            }
            $computedTotal += $quantity * (float) $product->price;
        }

        $userId = (int) $request->user()->getKey();

        DB::transaction(function () use ($cart, $products, $computedTotal, $userId, $request) {
            // Create order
            $order = Order::create([
                'customer_id' => $userId,
                'order_date' => now()->toDateString(),
                'total_cost' => $computedTotal,
                'status' => 'pending',
            ]);

            // Create items and decrement stock
            foreach ($cart as $pid => $item) {
                $pid = (int) $pid;
                $product = $products[$pid];
                $quantity = (int) $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->getKey(),
                    'product_id' => $product->getKey(),
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                if (isset($product->stock) && $product->stock !== null) {
                    // Prevent race conditions by checking stock again and updating
                    $affected = Product::where('product_id', $product->getKey())
                        ->where('stock', '>=', $quantity)
                        ->decrement('stock', $quantity);
                    if ($affected === 0) {
                        throw new \RuntimeException('Insufficient stock during checkout.');
                    }
                }
            }

            // Clear cart
            $request->session()->forget('cart');
        });

        return redirect()->route('customer.orders')->with('success', __('Order placed successfully.'));
    }
} 
