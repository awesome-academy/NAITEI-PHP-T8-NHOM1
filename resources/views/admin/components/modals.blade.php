<!-- User Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ __('Add New User') }}</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('userModal')">&times;</button>
        </div>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Username') }}</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Full Name') }}</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Role') }}</label>
                    <select class="form-control" required>
                        <option value="">{{ __('Select Role') }}</option>
                        <option value="customer">{{ __('Customer') }}</option>
                        <option value="admin">{{ __('Admin') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Password') }}</label>
                <input type="password" class="form-control" required>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('userModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add User') }}</button>
            </div>
        </form>
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
                <!-- <img id="edit_category_preview" src="" alt="Preview" style="max-width: 100px; margin-top: 10px;"> -->
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
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Product Name') }}</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Category') }}</label>
                    <select class="form-control" required>
                        <option value="">{{ __('Select Category') }}</option>
                        <option value="1">{{ __('Living Room') }}</option>
                        <option value="2">{{ __('Bedroom') }}</option>
                        <option value="3">{{ __('Kitchen') }}</option>
                        <option value="4">{{ __('Dining Room') }}</option>
                        <option value="5">{{ __('Office') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('Cost (VNĐ)') }}</label>
                    <input type="number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Quantity') }}</label>
                    <input type="number" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Images') }}</label>
                <input type="file" class="form-control" accept="image/*" multiple>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('productModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add Product') }}</button>
            </div>
        </form>
    </div>
</div>
