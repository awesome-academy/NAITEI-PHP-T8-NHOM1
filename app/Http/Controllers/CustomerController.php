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
    public function categories(Request $request)
    {
        $query = Category::withCount('products');
        
        // Search functionality for categories
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }
        
        // Sorting functionality for categories
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'products_asc':
                    $query->orderBy('products_count', 'asc');
                    break;
                case 'products_desc':
                    $query->orderBy('products_count', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }
        
        $categories = $query->paginate(10);
        
        return view('customer.pages.categories', compact('categories'));
    }

    /**
     * Display products in a specific category
     */
    public function products($categoryId, Request $request)
    {
        $category = Category::findOrFail($categoryId);
        
        $query = Product::where('category_id', $categoryId)
                       ->with('category');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Price filter functionality
        if ($request->has('price_range') && !empty($request->price_range)) {
            $priceRange = $request->price_range;
            switch ($priceRange) {
                case 'under_1m':
                    $query->where('price', '<', 1000000);
                    break;
                case '1m_2m':
                    $query->whereBetween('price', [1000000, 1999999]);
                    break;
                case '2m_3m':
                    $query->whereBetween('price', [2000000, 2999999]);
                    break;
                case '3m_4m':
                    $query->whereBetween('price', [3000000, 3999999]);
                    break;
                case '4m_5m':
                    $query->whereBetween('price', [4000000, 4999999]);
                    break;
                case '5m_6m':
                    $query->whereBetween('price', [5000000, 5999999]);
                    break;
                case '6m_7m':
                    $query->whereBetween('price', [6000000, 6999999]);
                    break;
                case '7m_8m':
                    $query->whereBetween('price', [7000000, 7999999]);
                    break;
                case '8m_9m':
                    $query->whereBetween('price', [8000000, 8999999]);
                    break;
                case '9m_10m':
                    $query->whereBetween('price', [9000000, 9999999]);
                    break;
                case 'over_10m':
                    $query->where('price', '>=', 10000000);
                    break;
            }
        }
        
        // Sorting functionality
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }
        
        $products = $query->get();
        
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
                      ->orderBy('created_at', 'desc');            
        $orders = Order::with([
            'orderItems.product' => function ($query) {
                $query->select('product_id', 'name', 'price'); // Add other needed columns here
            },
            'statusOrders'
        ])
        ->where('customer_id', $customer->id)
        ->orderBy('created_at', 'desc')
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
              ->where('customer_id', $customer->id)
              ->findOrFail($orderId);
        
        return view('customer.pages.order-details', compact('order'));
    }

    public function cancelOrder($orderId, Request $request)
    {
        $customer = Auth::user();
        
        $order = Order::where('customer_id', $customer->id)
                     ->where('order_id', $orderId)
                     ->first();
        
        if (!$order) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('Order not found')
                ], 404);
            }
            return redirect()->route('customer.orders')->with('error', __('Order not found'));
        }
        
        // Check if order can be cancelled

        if (!in_array($order->status, ['pending', 'confirmed', 'approved'])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('This order cannot be cancelled')
                ], 400);
            }
            return redirect()->route('customer.orders.details', $orderId)->with('error', __('This order cannot be cancelled'));
        }
        
        try {
            // Update order status to cancelled
            $order->update(['status' => 'cancelled']);
            
            // Add status history
            $order->statusOrders()->create([
                'action_type' => 'cancelled',
                'date' => now(),
                'admin_id' => null
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => __('Order has been cancelled successfully')
                ]);
            }
            return redirect()->route('customer.orders.details', $orderId)->with('success', __('Order has been cancelled successfully'));
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('An error occurred while cancelling the order')
                ], 500);
            }
            return redirect()->route('customer.orders.details', $orderId)->with('error', __('An error occurred while cancelling the order'));
        }
    }
}
