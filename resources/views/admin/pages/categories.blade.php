@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Category Management</h2>
            <button class="btn btn-primary" data-modal="categoryModal" type="button">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>
        <div style="padding: 20px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Products Count</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>#{{ $category->category_id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count }} products</td>
                        <td>{{ $category->created_at ? $category->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td><span class="status-badge status-active">Active</span></td>
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
                        <td colspan="6" style="text-align: center;">No categories found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
