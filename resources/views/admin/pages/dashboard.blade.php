@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_users']) }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_users'] }} registered users
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_categories']) }}</div>
                    <div class="stat-label">Categories</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_categories'] }} active categories
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_products']) }}</div>
                    <div class="stat-label">Products</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_products'] }} products available
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_orders']) }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_orders'] }} total orders (all statuses)
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ number_format($stats['total_feedbacks']) }}</div>
                    <div class="stat-label">Customer Reviews</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $stats['total_feedbacks'] }} customer feedbacks
            </div>
        </div>
    </div>
</div>
@endsection
