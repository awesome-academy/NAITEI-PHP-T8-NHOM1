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
                        <td>
                            @if($user->id !== auth()->id())
                                {{-- only super admin can toggle other admins --}}
                                @if(($user->role_id == 1 && auth()->user()->email === 'admin1@gmail.com') || $user->role_id != 1)
                                    @if($user->is_activate ?? true)
                                        <span class="status-badge status-active toggle-status-btn" 
                                              data-id="{{ $user->id }}" 
                                              data-status="1"
                                              title="Click to deactivate">
                                            <i class="fas fa-check-circle"></i> {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive toggle-status-btn" 
                                              data-id="{{ $user->id }}" 
                                              data-status="0"
                                              title="Click to activate">
                                            <i class="fas fa-times-circle"></i> {{ __('Inactive') }}
                                        </span>
                                    @endif
                                @else
                                    {{-- other admin cant toggle --}}
                                    @if($user->is_activate ?? true)
                                        <span class="status-badge status-active"><i class="fas fa-check-circle"></i> {{ __('Active') }}</span>
                                    @else
                                        <span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> {{ __('Inactive') }}</span>
                                    @endif
                                @endif
                            @else
                                @if($user->is_activate ?? true)
                                    <span class="status-badge status-active"><i class="fas fa-check-circle"></i> {{ __('Active') }}</span>
                                @else
                                    <span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> {{ __('Inactive') }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role-id="{{ $user->role_id}}"
                                    data-is-activate="{{ $user->is_activate ?? 1 }}"
                                    >
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            @if($user->id !== auth()->id() && !($user->is_activate ?? 1))
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
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
            const isActivate = button.dataset.isActivate;

            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_user_name').value = name;
            document.getElementById('edit_user_email').value = email;
            document.getElementById('edit_user_role').value = roleId;
            document.getElementById('edit_user_is_activate').value = isActivate;
            document.getElementById('editUserForm').action = `/admin/users/${id}`;

            adminPanel.openModal('editUserModal');
        });
    });

    // toggle/deactivate user status
    document.querySelectorAll('.toggle-status-btn').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.id;
            const currentStatus = button.dataset.status === '1';
            const actionText = currentStatus ? 'deactivate' : 'activate';
            
            if (confirm(`Are you sure you want to ${actionText} this user?`)) {
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                button.style.pointerEvents = 'none';
                
                fetch(`/admin/users/${userId}/toggle-activation`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).then(async response => {
                    if (response.ok) {
                        const data = await response.json();
                        if (data.success) {
                            button.innerHTML = '<i class="fas fa-check"></i> Success!';
                            button.classList.add(data.is_activate ? 'status-active' : 'status-inactive');
                            button.classList.remove(data.is_activate ? 'status-inactive' : 'status-active');
                            
                            setTimeout(() => {
                                // redirect to page 1 after toggle action
                                const url = new URL(window.location);
                                url.searchParams.delete('page');
                                window.location.href = url.toString();
                            }, 500);
                        } else {
                            alert(data.message);
                            button.innerHTML = originalText;
                            button.style.pointerEvents = 'auto';
                        }
                    } else {
                        const data = await response.json();
                        alert(data.message || 'Failed to update user status.');
                        button.innerHTML = originalText;
                        button.style.pointerEvents = 'auto';
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating user status.');
                    button.innerHTML = originalText;
                    button.style.pointerEvents = 'auto';
                });
            }
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
