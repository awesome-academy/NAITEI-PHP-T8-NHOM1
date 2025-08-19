@extends('customer.layouts.app')

@section('title', $category->name . ' Products - Furniro')

@section('hero')
<section class="hero-section">
    <div class="hero-content">
        <h1>{{ $category->name }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('customer.categories') }}">{{ __('Home') }}</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('customer.categories') }}">{{ __('Shop') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $category->name }}</span>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Filter Bar -->
<div class="filter-bar">
    <div class="filter-left">
        <button class="filter-btn">
            <i class="fas fa-filter"></i>
            {{ __('Filter') }}
        </button>
        
        <div class="view-options">
            <button class="view-btn active">
                <i class="fas fa-th-large"></i>
            </button>
            <button class="view-btn">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    
    <div class="filter-right">
        <span class="showing-text">{{ __('Showing') }} 1-{{ $products->count() }} {{ __('of') }} {{ $products->count() }} {{ __('products') }}</span>
        
        <div style="display: flex; gap: 15px; align-items: center;">
            <label>{{ __('Show') }}</label>
            <select class="show-select">
                <option>16</option>
                <option>32</option>
                <option>48</option>
            </select>
            
            <label>{{ __('Sort by') }}</label>
            <select class="sort-select">
                <option>{{ __('Default') }}</option>
                <option>{{ __('Price Low-High') }}</option>
                <option>{{ __('Price High-Low') }}</option>
                <option>{{ __('Name A-Z') }}</option>
                <option>{{ __('Name Z-A') }}</option>
            </select>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="products-grid">
    @forelse($products as $product)
    <div class="product-card">
        <div class="product-image">
            <img src="{{ asset($product->image ?? 'images/default-product.svg') }}" alt="{{ $product->name }}">
            
            <!-- Product badges -->
            @if(!empty($product->discount_percentage))
                <span class="product-badge discount">-{{ $product->discount_percentage }}%</span>
            @endif
            @if(!empty($product->is_new))
                <span class="product-badge new">New</span>
            @endif
            @if($product->stock <= 0)
                <span class="product-badge out-of-stock">{{ __('Out of Stock') }}</span>
            @elseif($product->stock <= 5)
                <span class="product-badge low-stock">{{ __('Low Stock') }}</span>
            @endif
            
            <div class="product-overlay">
                @if($product->stock > 0)
                    <button class="add-to-cart-btn" data-url="{{ route('customer.cart.add', ['product' => $product]) }}">{{ __('Add to cart') }}</button>
                @else
                    <button class="add-to-cart-btn disabled" disabled>{{ __('Out of Stock') }}</button>
                @endif
                <div class="product-actions">
                    <a href="{{ route('customer.feedbacks', $product->product_id) }}" class="action-btn">
                        <i class="fas fa-comments"></i>
                        {{ __('Feedback') }}
                    </a>
                    <button class="action-btn">
                        <i class="fas fa-random"></i>
                        {{ __('Compare') }}
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-heart"></i>
                        {{ __('Like') }}
                    </button>
                </div>
            </div>
        </div>
        
        <div class="product-info">
            <h3>{{ $product->name }}</h3>
            <p class="product-desc">{{ $product->description }}</p>
            <div class="product-price">
                <span class="current-price">{{ number_format($product->price, 0, '.', ',') }} {{ __('VND') }}</span>
                @if($loop->index % 3 == 0)
                    <span class="original-price">{{ number_format($product->price * 1.3, 0, '.', ',') }} {{ __('VND') }}</span>
                @endif
            </div>
            <div class="stock-info">
                @if($product->stock > 0)
                    <span class="stock-available">{{ __('In Stock') }}: {{ $product->stock }}</span>
                @else
                    <span class="stock-out">{{ __('Out of Stock') }}</span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="no-products">
        <p>{{ __('No products available in this category.') }}</p>
        <a href="{{ route('customer.categories') }}" class="back-btn">{{ __('Back to Categories') }}</a>
    </div>
    @endforelse
</div>

@if($products->count() > 12)
<!-- Pagination -->
<div class="pagination-wrapper">
    <div class="pagination">
        <button class="page-btn">1</button>
        <button class="page-btn active">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">Next</button>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(285px, 1fr));
    gap: 32px;
    margin-bottom: 60px;
}

.product-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    z-index: 2;
}

.product-badge.discount {
    background: #E97171;
    color: white;
}

.product-badge.new {
    background: #2EC1AC;
    color: white;
}

.product-badge.out-of-stock {
    background: #E74C3C;
    color: white;
}

.product-badge.low-stock {
    background: #F39C12;
    color: white;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(58, 58, 58, 0.72);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 15px;
    opacity: 0;
    transition: opacity 0.3s;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.add-to-cart-btn {
    background: #B88E2F;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.add-to-cart-btn:hover {
    background: #A67F2A;
}

.add-to-cart-btn.disabled {
    background: #ccc;
    color: #666;
    cursor: not-allowed;
}

.add-to-cart-btn.disabled:hover {
    background: #ccc;
}

.product-actions {
    display: flex;
    gap: 20px;
}

.action-btn {
    background: none;
    border: none;
    color: white;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.3s;
}

.action-btn:hover {
    color: #B88E2F;
}

.product-info {
    padding: 20px;
}

.product-info h3 {
    font-size: 20px;
    font-weight: 600;
    color: #3A3A3A;
    margin-bottom: 8px;
}

.product-desc {
    color: #898989;
    font-size: 14px;
    margin-bottom: 12px;
    line-height: 1.5;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 10px;
}

.current-price {
    font-size: 18px;
    font-weight: 600;
    color: #3A3A3A;
}

.original-price {
    font-size: 14px;
    color: #B0B0B0;
    text-decoration: line-through;
}

.no-products {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
}

.no-products p {
    color: #666;
    font-size: 18px;
    margin-bottom: 20px;
}

.back-btn {
    background: #B88E2F;
    color: white;
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 600;
    transition: background 0.3s;
}

.back-btn:hover {
    background: #A67F2A;
}

/* Stock Info */
.stock-info {
    margin-top: 10px;
}

.stock-available {
    color: #27AE60;
    font-size: 12px;
    font-weight: 500;
}

.stock-out {
    color: #E74C3C;
    font-size: 12px;
    font-weight: 500;
}
</style>
@endpush

@section('scripts')
<script>
// Script for Add to Cart functionality
document.addEventListener('DOMContentLoaded', function () {
    // Get the CSRF token from the meta tag in the document head.
    // This token is essential for Laravel to protect against Cross-Site Request Forgery (CSRF) attacks.
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Select all buttons with the class 'add-to-cart-btn' that also have a 'data-url' attribute.
    // The 'data-url' attribute holds the URL where the cart addition request should be sent.
    document.querySelectorAll('.add-to-cart-btn[data-url]').forEach(function (btn) {
        // Attach a click event listener to each 'Add to cart' button.
        btn.addEventListener('click', function (e) {
            // Prevent the default form submission behavior of the button.
            e.preventDefault();

            // Get the URL for the cart addition request from the 'data-url' attribute.
            var url = btn.getAttribute('data-url');
            
            // If no URL is found, stop the function execution.
            if (!url) return;

            // Create a new HTML <form> element dynamically.
            var form = document.createElement('form');
            form.method = 'POST'; // Set the form method to POST.
            form.action = url;    // Set the form action URL.

            // Create a hidden input field for the CSRF token.
            var tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token'; // Laravel expects the CSRF token in a field named '_token'.
            tokenInput.value = csrf;    // Assign the retrieved CSRF token value.
            form.appendChild(tokenInput); // Append the CSRF token input to the form.

            // Create a hidden input field for the quantity (defaulting to 1).
            var qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = 'quantity';
            qtyInput.value = '1';
            form.appendChild(qtyInput); // Append the quantity input to the form.

            // Append the dynamically created form to the document body.
            // This is necessary for the form to be submit-able by JavaScript.
            document.body.appendChild(form);

            // Submit the form programmatically.
            // This will trigger a POST request to the specified URL.
            form.submit();
        });
    });
});
</script>
@endsection
