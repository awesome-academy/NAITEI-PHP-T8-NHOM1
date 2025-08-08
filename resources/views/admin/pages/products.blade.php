@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">{{ __('Products Management') }}</h2>
            <button class="btn btn-primary" data-modal="productModal" type="button">
                <i class="fas fa-plus"></i> {{ __('Add Product') }}
            </button>
        </div>
        <div style="padding: 20px;">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="{{ __('Search products...') }}">
                <select class="form-control" style="width: auto;">
                    <option>{{ __('All Categories') }}</option>
                    @foreach($products->pluck('category')->unique() as $category)
                        @if($category)
                            <option>{{ __($category->name) }}</option>
                        @endif
                    @endforeach
                </select>
                <button class="btn btn-secondary">
                    <i class="fas fa-search"></i> {{ __('Search') }}
                </button>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Product Name') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>#{{ $product->product_id }}</td>
                        <td>
                            <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                @else
                                    <i class="fas fa-image" style="color: #ccc;"></i>
                                @endif
                            </div>
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ __($product->category->name) ?? __('N/A') }}</td>
                        <td>{{ number_format($product->price) }} VNĐ</td>
                        <td>{{ Str::limit($product->description, 50) }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">{{ __('No products found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
