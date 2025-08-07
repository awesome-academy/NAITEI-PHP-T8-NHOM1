@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Users Management</h2>
            <button class="btn btn-primary" data-modal="userModal" type="button">
                <i class="fas fa-plus"></i> Add User
            </button>
        </div>
        <div style="padding: 20px;">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search by name, email...">
                <button class="btn btn-secondary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role->name ?? 'N/A' }}</td>
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
                        <td colspan="7" style="text-align: center;">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
