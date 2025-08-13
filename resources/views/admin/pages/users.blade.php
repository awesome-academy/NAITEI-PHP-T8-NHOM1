@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">{{ __('Users Management') }}</h2>
            <button class="btn btn-primary" data-modal="userModal" type="button">
                <i class="fas fa-plus"></i> {{ __('Add User') }}
            </button>
        </div>
        <div style="padding: 20px;">

            <form method="GET" action="{{ route('admin.users.search') }}" class="search-bar">
                <input type="text" name="query" id="searchInput" class="search-input" 
                    placeholder="{{ __('Search by name, email...') }}"
                    value="{{ request('query', '') }}">
                <select name="role_id" id="roleFilter" class="form-control" style="width: auto;">
                    <option value="">{{ __('All Roles') }}</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}" 
                            {{ request('role_id') == $role->role_id ? 'selected' : '' }}>
                            {{ __($role->name) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> {{ __('Search') }}
                </button>
            </form>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Username') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name ? __($user->role->name) : __('N/A') }}</td>
                        <td><span class="status-badge status-active">{{ __('Active') }}</span></td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role-id="{{ $user->role_id}}"
                                    {{-- data-modal="editUserModal" --}}
                                    >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">{{ __('No users found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $users->links('pagination.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('searchInput').addEventListener('keypress', function() {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.closest('form').submit();
            }
        });
        document.getElementById('roleFilter').addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // Mở modal edit
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const email = button.dataset.email;
            const roleId = button.dataset.roleId;

            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_user_name').value = name;
            document.getElementById('edit_user_email').value = email;
            document.getElementById('edit_user_role').value = roleId;
            document.getElementById('editUserForm').action = `/admin/users/${id}`;

            adminPanel.openModal('editUserModal');
        });
    });

    // Xử lý xóa người dùng
    let userIdToDelete = null;
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            userIdToDelete = button.dataset.id;
            adminPanel.openModal('deleteUserModal');
        });
    });

    // Xử lý xác nhận xóa người dùng
    document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
        adminPanel.closeModal('deleteUserModal');
        userIdToDelete = null;
    });
    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        if (!userIdToDelete) return;
        fetch(`/admin/users/${userIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(async response => {
            if (response.ok) {
                window.location.reload();
            } else {
                let errorMsg = 'Failed to delete user.';
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
        adminPanel.closeModal('deleteUserModal');
        userIdToDelete = null;
    });
</script>
@endsection