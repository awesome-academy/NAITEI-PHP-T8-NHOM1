@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_users']) }}</div>
                    <div class="stat-label">{{ __('Total Users') }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_users'] }} {{ __('registered users') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_categories']) }}</div>
                    <div class="stat-label">{{ __('Categories') }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_categories'] }} {{ __('active categories') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_products']) }}</div>
                    <div class="stat-label">{{ __('Products') }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_products'] }} {{ __('products available') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_orders']) }}</div>
                    <div class="stat-label">{{ __('Total Orders') }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_orders'] }} {{ __('total orders (all statuses)') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_feedbacks']) }}</div>
                    <div class="stat-label">{{ __('Customer Reviews') }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_feedbacks'] }} {{ __('customer feedbacks') }}
            </div>
        </div>
    </div>
</div>
@endsection
