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
        <form>
            <div class="form-group">
                <label class="form-label">{{ __('Category Name') }}</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('categoryModal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add Category') }}</button>
            </div>
        </form>
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
