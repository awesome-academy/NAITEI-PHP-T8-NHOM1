<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class AdminController extends Controller
{
    private const CATEGORY_IMAGE_DIR = 'images/categories';
    private const PRODUCT_IMAGE_DIR = 'images/products';

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
        $users = User::paginate(10);
        return view('admin.pages.users', compact('users'));
    }

    public function categories()
    {
        // count products in each category
        $categories = Category::withCount('products')->get();
        return view('admin.pages.categories', compact('categories'));
    }

    public function storeCategory(StoreCategoryRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255|unique:categories,name',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        $validated = $request->validated();
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'svg'];
            $extension = $image->guessExtension();
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()->withErrors(['image' => 'Invalid image extension.']);
            }
            $imageName = Str::uuid() . '.' . $extension;
            $image->move(public_path(self::CATEGORY_IMAGE_DIR), $imageName);
            $imagePath = self::CATEGORY_IMAGE_DIR . '/' . $imageName;
            $validated['image'] = $imagePath; 
            
        }

        Category::create($validated);

        return redirect()->route('admin.categories')->with('success', 'Category added successfully.');
    }

    public function updateCategory(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Xóa image cũ nếu có
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }
            
            $image = $request->file('image');
            // $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $imageName = Str::uuid() . '.' . $image->extension();
            $image->move(public_path(self::CATEGORY_IMAGE_DIR), $imageName);
            $validated['image'] = self::CATEGORY_IMAGE_DIR . '/' . $imageName;
        }

        $category->update($validated);
        return redirect()->route('admin.categories')->with('success', 'Category updated.');
    }

    public function deleteCategory(Category $category)
    {
        // Prevent deletion if category has associated products
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with associated products.'
            ], 400);
        }
        // Xóa image file nếu có
        if ($category->image) {
            // Nếu dùng public/images/categories/
            if (File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }
        }
        
        $category->delete();
        return response()->json(['success' => true]);
    }

    public function products()
    {
        $products = Product::with('category')->paginate(10); // paginate products (10 per page)
        $categories = Category::all();
        return view('admin.pages.products', compact('products', 'categories'));
    }

    public function storeProduct(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'svg'];
            $extension = $image->guessExtension();
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()->withErrors(['image' => 'Invalid image extension.']);
            }
            $imageName = Str::uuid() . '.' . $extension;
            $image->move(public_path(self::PRODUCT_IMAGE_DIR), $imageName);
            $validated['image'] = self::PRODUCT_IMAGE_DIR . '/' . $imageName;
        }

        Product::create($validated);
        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    public function updateProduct(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // delete the old image
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->extension();
            $image->move(public_path(self::PRODUCT_IMAGE_DIR), $imageName);
            $validated['image'] = self::PRODUCT_IMAGE_DIR . '/' . $imageName;
        }

        $product->update($validated);
        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(Product $product)
    {
        // delete the old image
        if ($product->image) {
            if (File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
        }
        
        $product->delete();
        return response()->json(['success' => true]);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->input('category_id');
        
        $productsQuery = Product::with('category');
        
        // search filter
        if (!empty($query)) {
            // $productsQuery->where(function($q) use ($query) {
            //     $q->where('name', 'like', "%{$query}%");
            // }); // use this if we want to search in multiple fields

            $productsQuery->where('name', 'like', "%{$query}%");
        }
        
        // category filter
        if (!empty($categoryId) && $categoryId !== 'all') {
            $productsQuery->where('category_id', $categoryId);
        }
        
        $products = $productsQuery->paginate(10);
        $categories = Category::all();
        
        // ensure that search parameters are kept in pagination links
        $products->appends($request->only(['query', 'category_id']));
        
        return view('admin.pages.products', compact('products', 'categories'));
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
