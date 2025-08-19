<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display the categories page for customers
     */
    public function categories()
    {
        $categories = Category::withCount('products')->paginate(10);
        
        return view('customer.pages.categories', compact('categories'));
    }

    /**
     * Display products in a specific category
     */
    public function products($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = Product::where('category_id', $categoryId)
                          ->with('category')
                          ->get();
        
        return view('customer.pages.products', compact('category', 'products'));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return view('customer.pages.about');
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('customer.pages.contact');
    }

    /**
     * Display the order history page for customers
     */
    public function orders(Request $request)
    {
        $customer = Auth::user();
        
        // Get orders with their items and status history
        $orders = Order::with(['orderItems.product', 'statusOrders'])
                      ->where('customer_id', $customer->id)
                      ->orderBy('order_date', 'desc');            
        $orders = Order::with([
            'orderItems.product' => function ($query) {
                $query->select('id', 'name', 'price'); // Add other needed columns here
            },
            'statusOrders'
        ])
        ->where('customer_id', $customer->id)
        ->orderBy('order_date', 'desc')
        ->paginate(10);

        
        return view('customer.pages.orders', compact('orders'));
    }

    /**
     * Display detailed information about a specific order
     */
    public function orderDetails($orderId)
    {
        $customer = Auth::user();
        
        // Get specific order with all related data
        $order = Order::with(['orderItems.product', 'statusOrders.admin', 'user'])
                     ->where('order_id', $orderId)
                     ->where('customer_id', $customer->id);
        
        return view('customer.pages.order-details', compact('order'));
    }
}
