<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Feedback;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_id', '>', 0)->count(),
            'total_feedbacks' => Feedback::count()
        ];
        
        return view('admin.pages.dashboard', compact('stats'));
    }

    public function dashboardStats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_id', '>', 0)->count(),
            'total_feedbacks' => Feedback::count()
        ];
        
        return response()->json($stats);
    }

    public function users()
    {
        $users = User::all();
        return view('admin.pages.users', compact('users'));
    }

    public function categories()
    {
        // count products in each category
        $categories = Category::withCount('products')->get();
        return view('admin.pages.categories', compact('categories'));
    }

    public function products()
    {
        $products = Product::with('category')->get();
        return view('admin.pages.products', compact('products'));
    }

    public function orders()
    {
        $orders = Order::with('user')->get();
        return view('admin.pages.orders', compact('orders'));
    }

    public function feedbacks()
    {
        $feedbacks = Feedback::with('user', 'product')->get();
        return view('admin.pages.feedbacks', compact('feedbacks'));
    }
}
