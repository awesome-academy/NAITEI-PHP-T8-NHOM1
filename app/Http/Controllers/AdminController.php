<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Feedback;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user is admin (role_id = 1)
            if ($user->role_id !== 1) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Only administrators can access this panel.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

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
