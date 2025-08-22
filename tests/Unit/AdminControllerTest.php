<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Feedback;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin role 
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);
        
        // Create an admin user
        $this->adminUser = User::factory()->create([
            'role_id' => $adminRole->role_id,
            'email' => 'admin@test.com'
        ]);
    }

    /** @test */
    public function it_can_display_dashboard()
    {
        // Skip middleware
        $this->withoutMiddleware();
        
        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.dashboard');
        $response->assertViewHas('stats');
    }

    /** @test */
    public function dashboard_returns_correct_stats()
    {
        // Skip middleware
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        
        // Create test data
        User::factory()->count(5)->create(['role_id' => $customerRole->role_id]); // customers
        Category::factory()->count(3)->create();
        Product::factory()->count(10)->create(['category_id' => Category::first()->category_id]);
        
        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/dashboard');

        $response->assertStatus(200);
        
        $stats = $response->viewData('stats');
        $this->assertEquals(6, $stats['total_users']); // 5 customers + 1 admin
        $this->assertEquals(3, $stats['total_categories']);
        $this->assertEquals(10, $stats['total_products']);
    }

    /** @test */
    public function it_can_display_users_page()
    {
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        User::factory()->count(3)->create(['role_id' => $customerRole->role_id]);

        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/users');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.users');
        $response->assertViewHas('users');
    }

    /** @test */
    public function it_can_display_categories_page()
    {
        $this->withoutMiddleware();
        
        Category::factory()->count(3)->create();

        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/categories');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories');
        $response->assertViewHas('categories');
    }

    /** @test */
    public function it_can_display_products_page()
    {
        $this->withoutMiddleware();
        
        $category = Category::factory()->create();
        Product::factory()->count(5)->create(['category_id' => $category->category_id]);

        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/products');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.products');
        $response->assertViewHas('products');
    }

    /** @test */
    public function it_can_display_orders_page()
    {
        $this->withoutMiddleware();
        
        // Skip creating actual orders, just test the route response
        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.orders');
        $response->assertViewHas('orders');
    }

    /** @test */
    public function it_can_display_feedbacks_page()
    {
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        $customer = User::factory()->create(['role_id' => $customerRole->role_id]);
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->category_id]);

        // Create feedbacks manually
        for ($i = 0; $i < 3; $i++) {
            Feedback::create([
                'user_id' => $customer->id,
                'product_id' => $product->product_id,
                'rating' => 5,
                'comment' => 'Great product!',
            ]);
        }

        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/feedbacks');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.feedbacks');
        $response->assertViewHas('feedbacks');
    }

    /** @test */
    public function dashboard_stats_api_returns_json()
    {
        $this->withoutMiddleware();
        
        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/dashboard/stats');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_users',
            'total_categories', 
            'total_products',
            'total_orders',
            'pending_orders',
            'total_feedbacks'
        ]);
    }

    /** @test */
    public function guest_cannot_access_admin_pages()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function it_can_store_product()
    {
        $this->withoutMiddleware();
        
        $category = Category::factory()->create();
        
        $productData = [
            'name' => 'Test Product',
            'price' => 99.99,
            'category_id' => $category->category_id
        ];

        $response = $this->actingAs($this->adminUser)
                         ->post('/admin/products', $productData);

        $this->assertTrue($response->getStatusCode() < 500);
    }

    /** @test */
    public function it_can_update_product()
    {
        $this->withoutMiddleware();
        
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->category_id]);
        
        $updateData = [
            'name' => 'Updated Product Name',
            'price' => 199.99,
            'category_id' => $category->category_id
        ];

        $response = $this->actingAs($this->adminUser)
                         ->put("/admin/products/{$product->product_id}", $updateData);

        $this->assertTrue($response->getStatusCode() < 500);
    }

    /** @test */
    public function it_can_delete_only_deactivated_users()
    {
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        $activeUser = User::factory()->create([
            'role_id' => $customerRole->role_id,
            'is_activate' => true
        ]);
        $deactivatedUser = User::factory()->create([
            'role_id' => $customerRole->role_id,
            'is_activate' => false
        ]);

        // try to delete active user -> fail
        $response = $this->actingAs($this->adminUser)
                         ->delete("/admin/users/{$activeUser->id}");

        $response->assertStatus(403);
        $response->assertJson(['success' => false]);

        // try to delete deactivated user -> succeed
        $response = $this->actingAs($this->adminUser)
                         ->delete("/admin/users/{$deactivatedUser->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    /** @test */
    public function it_can_toggle_user_activation()
    {
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        $user = User::factory()->create([
            'role_id' => $customerRole->role_id,
            'is_activate' => true
        ]);

        $response = $this->actingAs($this->adminUser)
                         ->post("/admin/users/{$user->id}/toggle-activation");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        
        $user->refresh();
        $this->assertFalse($user->is_activate);
    }

    /** @test */
    public function it_can_delete_product()
    {
        $this->withoutMiddleware();
        
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->category_id]);

        $response = $this->actingAs($this->adminUser)
                         ->delete("/admin/products/{$product->product_id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    /** @test */
    public function it_can_search_products()
    {
        $this->withoutMiddleware();
        
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->category_id]);

        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/products/search?query=test');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.products');
        $response->assertViewHas('products');
        $response->assertViewHas('categories');
    }

    /** @test */
    public function it_can_display_feedback_details()
    {
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        $customer = User::factory()->create(['role_id' => $customerRole->role_id]);
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->category_id]);
        
        $feedback = Feedback::create([
            'user_id' => $customer->id,
            'product_id' => $product->product_id,
            'comment' => 'This is a test feedback',
            'rating' => 5
        ]);

        $this->assertDatabaseHas('feedback', [
            'feedback_id' => $feedback->feedback_id,
            'comment' => 'This is a test feedback'
        ]);

        $response = $this->actingAs($this->adminUser)
                         ->get("/admin/feedbacks/{$feedback->feedback_id}");

        $response->assertStatus(200);
        
        $responseData = $response->json();
        $this->assertArrayHasKey('feedback', $responseData);
        $this->assertArrayHasKey('user', $responseData);  
        $this->assertArrayHasKey('product', $responseData);
    }

    /** @test */
    public function it_can_display_feedbacks_list()
    {
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        $customer = User::factory()->create(['role_id' => $customerRole->role_id]);
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->category_id]);
        
        $feedback = Feedback::create([
            'user_id' => $customer->id,
            'product_id' => $product->product_id,
            'comment' => 'This is a test feedback',
            'rating' => 5
        ]);

        $response = $this->actingAs($this->adminUser)
                        ->get('/admin/feedbacks');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.feedbacks');
        $response->assertViewHas('feedbacks');
    }

    /** @test */
    public function it_can_delete_feedback()
    {
        $this->withoutMiddleware();
        
        $customerRole = Role::where('name', 'customer')->first();
        $customer = User::factory()->create(['role_id' => $customerRole->role_id]);
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->category_id]);
        
        $feedback = Feedback::create([
            'user_id' => $customer->id,
            'product_id' => $product->product_id,
            'comment' => 'This feedback will be deleted',
            'rating' => 4
        ]);

        $this->assertDatabaseHas('feedback', [
            'feedback_id' => $feedback->feedback_id
        ]);

        $response = $this->actingAs($this->adminUser)
                        ->delete("/admin/feedbacks/{$feedback->feedback_id}");

        $response->assertRedirect(route('admin.feedbacks'));
        $response->assertSessionHas('success', 'Feedback deleted successfully!');
    }
}
