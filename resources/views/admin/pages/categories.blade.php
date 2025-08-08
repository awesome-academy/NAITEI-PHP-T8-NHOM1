@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">{{ __('Category Management') }}</h2>
            <button class="btn btn-primary" data-modal="categoryModal" type="button">
                <i class="fas fa-plus"></i> {{ __('Add Category') }}
            </button>
        </div>
        <div style="padding: 20px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Category Name') }}</th>
                        <th>{{ __('Products Count') }}</th>
                        <th>{{ __('Created Date') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>#{{ $category->category_id }}</td>
                        <td>{{ __($category->name) }}</td>
                        <td>{{ $category->products_count }} {{ __('products') }}</td>
                        <td>{{ $category->created_at ? $category->created_at->format('d/m/Y') : __('N/A') }}</td>
                        <td><span class="status-badge status-active">{{ __('Active') }}</span></td>
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
                        <td colspan="6" style="text-align: center;">{{ __('No categories found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
