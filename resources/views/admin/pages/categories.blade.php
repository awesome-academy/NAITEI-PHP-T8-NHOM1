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
                    <tr data-id="{{ $category->category_id }}">
                        <td>#{{ $category->category_id }}</td>
                        <td>{{ __($category->name) }}</td>
                        <td>{{ $category->products_count }} {{ __('products') }}</td>
                        <td>{{ $category->created_at ? $category->created_at->format('d/m/Y') : __('N/A') }}</td>
                        <td><span class="status-badge status-active">{{ __('Active') }}</span></td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn"
                                    data-id="{{ $category->category_id }}"
                                    data-name="{{ $category->name }}"
                                    data-image="{{ $category->image }}"
                                    {{-- data-modal="editCategoryModal"  --}}
                                    >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $category->category_id }}">
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

@section('scripts')
<script>
    // Mở modal edit
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const image = button.dataset.image;

            document.getElementById('edit_category_id').value = id;
            document.getElementById('edit_category_name').value = name;
            document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
            
            // Check null trước khi set src
            // const previewImg = document.getElementById('edit_category_preview');
            // if (image && image !== 'null' && image !== '') {
            //     previewImg.src = `/${image}`;
            //     previewImg.style.display = 'block';
            // } else {
            //     previewImg.src = '';
            //     previewImg.style.display = 'none';
            // }
            adminPanel.openModal('editCategoryModal');
        });
    });

    // Xử lý xoá category
    let categoryIdToDelete = null;
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            categoryIdToDelete = button.dataset.id;
            adminPanel.openModal('deleteCategoryModal');
        });
    });
    // Handle delete confirmation modal actions
    document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
        adminPanel.closeModal('deleteCategoryModal');
        categoryIdToDelete = null;
    });
    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        if (!categoryIdToDelete) return;
        fetch(`/admin/categories/${categoryIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        // }).then(response => {
        //     if (response.ok) {
        //         window.location.reload();
        //     } else {
        //         alert('Failed to delete category.');
        }).then(async response => {
            if (response.ok) {
                window.location.reload();
            } else {
                let errorMsg = 'Failed to delete category.';
                try {
                    const data = await response.json();
                    if (data && data.message) {
                        errorMsg = data.message;
                    }
                } catch (e) {
                    // Ignore JSON parse errors, use default message
                }
                alert(errorMsg);
            }
        });
        adminPanel.closeModal('deleteCategoryModal');
        categoryIdToDelete = null;
    });
</script>

@endsection
