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
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="{{ __('Search by name, email...') }}">
                <button class="btn btn-secondary">
                    <i class="fas fa-search"></i> {{ __('Search') }}
                </button>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Username') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Full Name') }}</th>
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
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role->name ? __($user->role->name) : __('N/A') }}</td>
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
                        <td colspan="7" style="text-align: center;">{{ __('No users found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
