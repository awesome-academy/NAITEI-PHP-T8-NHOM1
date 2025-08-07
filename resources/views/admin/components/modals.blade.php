<!-- User Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New User</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('userModal')">&times;</button>
        </div>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select class="form-control" required>
                        <option value="">Select Role</option>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" required>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('userModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
        </form>
    </div>
</div>

<!-- Category Modal -->
<div class="modal" id="categoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Category</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('categoryModal')">&times;</button>
        </div>
        <form>
            <div class="form-group">
                <label class="form-label">Category Name</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('categoryModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Product Modal -->
<div class="modal" id="productModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Product</h3>
            <button class="modal-close" onclick="adminPanel.closeModal('productModal')">&times;</button>
        </div>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Product Name</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-control" required>
                        <option value="">Select Category</option>
                        <option value="1">Living Room</option>
                        <option value="2">Bedroom</option>
                        <option value="3">Kitchen</option>
                        <option value="4">Dining Room</option>
                        <option value="5">Office</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Cost (VNĐ)</label>
                    <input type="number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Images</label>
                <input type="file" class="form-control" accept="image/*" multiple>
            </div>
            <div style="text-align: right; margin-top: 25px;">
                <button type="button" class="btn btn-secondary" onclick="adminPanel.closeModal('productModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</div>
