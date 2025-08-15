@extends('customer.layouts.app')

@section('title', 'Shop - Furniro')

@section('hero')
<section class="hero-section">
    <div class="hero-content">
        <h1>{{ __('Shop') }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('customer.categories') }}">{{ __('Home') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Shop') }}</span>
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
        <span class="showing-text">{{ __('Showing') }} 1-{{ $categories->count() }} {{ __('of') }} {{ $categories->count() }} {{ __('categories') }}</span>
        
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
                <option>{{ __('Name A-Z') }}</option>
                <option>{{ __('Name Z-A') }}</option>
                <option>{{ __('Products Count') }}</option>
            </select>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<div class="categories-grid">
    @forelse($categories as $category)
    <div class="category-card">
        <div class="category-image">
            <img src="{{ asset($category->image ?? 'images/default-category.svg') }}" alt="{{ $category->name }}">
            <div class="category-overlay">
                <a href="{{ route('customer.products', $category->category_id) }}" class="view-products-btn">
                    {{ __('View Products') }}
                </a>
            </div>
        </div>
        <div class="category-info">
            <h3>{{ $category->name }}</h3>
            <p class="category-desc">{{ $category->description }}</p>
            <p class="products-count">{{ $category->products_count }} {{ __('products') }}</p>
        </div>
    </div>
    @empty
    <div class="no-categories">
        <p>{{ __('No categories available at the moment.') }}</p>
    </div>
    @endforelse
</div>

@if($categories->count() > 12)
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
/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(285px, 1fr));
    gap: 32px;
    margin-bottom: 60px;
}

.category-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.category-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.category-card:hover .category-image img {
    transform: scale(1.1);
}

.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.category-card:hover .category-overlay {
    opacity: 1;
}

.view-products-btn {
    background: #B88E2F;
    color: white;
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 600;
    transition: background 0.3s;
}

.view-products-btn:hover {
    background: #A67F2A;
}

.category-info {
    padding: 20px;
}

.category-info h3 {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.category-desc {
    color: #666;
    font-size: 14px;
    margin-bottom: 12px;
    line-height: 1.5;
}

.products-count {
    color: #B88E2F;
    font-weight: 500;
    font-size: 14px;
}

.no-categories {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #666;
    font-size: 18px;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination {
    display: flex;
    gap: 8px;
}

.page-btn {
    padding: 12px 18px;
    border: 1px solid #ddd;
    background: #F9F1E7;
    color: #333;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.3s;
}

.page-btn:hover,
.page-btn.active {
    background: #B88E2F;
    color: white;
    border-color: #B88E2F;
}
</style>
@endpush
