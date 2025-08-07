<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display the categories page for customers
     */
    public function categories()
    {
        $categories = Category::withCount('products')->get();
        
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
}
