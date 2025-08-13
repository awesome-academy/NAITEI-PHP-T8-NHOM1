<!-- User Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Add New User') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('userModal')">&times;</button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Username') }}</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="form-row">    
                <div class="form-group">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Role') }}</label>
                    <select name="role_id" class="form-control" required>
                        <option value="">{{ __('Select Role') }}</option>
                        <option value="2">{{ __('Customer') }}</option>
                        <option value="1">{{ __('Admin') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Password') }}</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('userModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add User') }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal" id="editUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Edit User') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('editUserModal')">&times;</button>
        </div>
        <form id="editUserForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" id="edit_user_id">
            <div class="form-group">
                <label class="form-label" for="edit_user_name">{{ __('Username') }}</label>
                <input type="text" class="form-control" name="name" id="edit_user_name" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="edit_user_email">{{ __('Email') }}</label>
                <input type="email" class="form-control" name="email" id="edit_user_email" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="edit_user_role">{{ __('Role') }}</label>
                <select class="form-control" name="role_id" id="edit_user_role" required>
                    <option value="">{{ __('Select Role') }}</option>
                    <option value="2">{{ __('Customer') }}</option>
                    <option value="1">{{ __('Admin') }}</option>
                </select>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('editUserModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Update User') }} </button>
            </div>
        </form>
    </div>
</div>
<!-- Delete User Modal -->
<div class="modal" id="deleteUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Delete User') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('deleteUserModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}</p>
        </div>
        <div style="text-align: right; margin-top: 25px;">
            <button type="button" class="btn btn-secondary" id="cancelDeleteBtn">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('Delete') }}</button>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal" id="categoryModal">                                                                                                                                                                  
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Add New Category') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('categoryModal')">&times;</button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"> 
            @csrf
            <div class="form-group">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" required>                                                                                                                                                                                                                                               
            </div>

            <div class="form-group">
                <label class="form-label">Image</label>
                <input type="file"  id="categoryImage" name="image" class="form-control" accept="image/*">
                <div id="currentImage" style="margin-top: 10px; display: none;">
                    <label class="form-label">Current Image:</label><br>
                    <img id="currentImageSrc" src="" alt="Current category image" style="max-width: 100px; max-height: 100px;">
                </div>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('categoryModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add Category') }}</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Category Modal -->
<div class="modal" id="editCategoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Category</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('editCategoryModal')">&times;</button>
        </div>
        <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="category_id" id="edit_category_id">

            <div class="form-group">
                <label class="form-label" for="edit_category_name">Category Name</label>
                <input type="text" class="form-control" name="name" id="edit_category_name" required>
            </div>

            <div class="form-group">
                <label class="form-label">Image</label>
                <input type="file" id="edit_category_image" class="form-control" name="image">
                <!-- <img id="edit_category_preview" src="" alt="Pr                                                                                                                                                             eview" style="max-width: 100px; margin-top: 10px;"> -->
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('editCategoryModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </form>
    </div>
</div>
<!-- Delete Category Modal -->
<div class="modal" id="deleteCategoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Delete Category') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('deleteCategoryModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>{{ __('Are you sure you want to delete this category? This action cannot be undone.') }}</p>
        </div>
        <div style="text-align: right; margin-top: 25px;">
            <button type="button" class="btn btn-secondary" id="cancelDeleteBtn">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('Delete') }}</button>
        </div>
    </div>
</div>

<!-- Product Modal -->
<div class="modal" id="productModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Add New Product') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('productModal')">&times;</button>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Product Name') }}</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Category') }}</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Price (VNĐ)') }}</label>
                    <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Stock') }}</label>
                    <input type="number" name="stock" class="form-control" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Image') }}</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('productModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add Product') }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal" id="editProductModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Edit Product') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('editProductModal')">&times;</button>
        </div>
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="product_id" id="edit_product_id">
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Product Name') }}</label>
                    <input type="text" name="name" id="edit_product_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Category') }}</label>
                    <select name="category_id" id="edit_product_category" class="form-control" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Price (VNĐ)') }}</label>
                    <input type="number" name="price" id="edit_product_price" class="form-control" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Stock') }}</label>
                    <input type="number" name="stock" id="edit_product_stock" class="form-control" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea name="description" id="edit_product_description" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Image') }}</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('editProductModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Update Product') }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal" id="deleteProductModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Delete Product') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('deleteProductModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>{{ __('Are you sure you want to delete this product? This action cannot be undone.') }}</p>
        </div>
        <div style="text-align: right; margin-top: 25px;">
            <button type="button" class="btn btn-secondary" id="cancelDeleteProductBtn">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteProductBtn">{{ __('Delete') }}</button>
        </div>
    </div>
</div>

<!-- View Product Modal -->
<div class="modal" id="viewProductModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Product Details') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('viewProductModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Product ID') }}</label>
                    <input type="text" id="view_product_id" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Product Name') }}</label>
                    <input type="text" id="view_product_name" class="form-control" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Category') }}</label>
                    <input type="text" id="view_product_category" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Price (VNĐ)') }}</label>
                    <input type="text" id="view_product_price" class="form-control" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Stock') }}</label>
                    <input type="text" id="view_product_stock" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Status') }}</label>
                    <input type="text" id="view_product_status" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea id="view_product_description" class="form-control" rows="4" readonly></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Product Image') }}</label>
                <div id="view_product_image_container" style="margin-top: 10px;">
                    <img id="view_product_image" src="" alt="Product Image" style="max-width: 200px; max-height: 200px; border-radius: 8px; display: none;">
                    <p id="view_no_image" style="color: #666; display: none;">{{ __('No image available') }}</p>
                </div>
            </div>
        </div>
        <div style="text-align: right; margin-top: 25px;">
            <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('viewProductModal')">{{ __('Close') }}</button>
        </div>
    </div>
</div>
