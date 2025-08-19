@extends('customer.layouts.app')

@section('title', __('Orders') . ' - Furniro')

@section('hero')
<section class="hero-section">
    <div class="hero-content">
        <h1>{{ __('Orders') }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('customer.categories') }}">{{ __('Home') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Orders') }}</span>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="orders-container">
    <!-- Orders Header -->
    <div class="orders-header">
        <h2>{{ __('Order History') }}</h2>
        <p class="orders-subtitle">{{ __('Track your orders and view details') }}</p>
    </div>

    @if($orders->count() > 0)
        <!-- Orders List -->
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-info">
                        <h3 class="order-number">{{ __('Order') }} #{{ $order->order_id }}</h3>
                        <p class="order-date">{{ __('Order Date') }}: {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</p>
                    </div>
                    <div class="order-status">
                        @php
                            $latestStatus = $order->statusOrders->last();
                            $statusClass = match($order->status ?? 'pending') {
                                'pending' => 'status-pending',
                                'confirmed' => 'status-confirmed', 
                                'processing' => 'status-processing',
                                'shipped' => 'status-shipped',
                                'delivered' => 'status-delivered',
                                'cancelled' => 'status-cancelled',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="order-status-badge {{ $statusClass }}">
                            {{ __($order->status ?? 'pending') }}
                        </span>
                    </div>
                </div>

                <div class="order-summary">
                    <div class="order-items">
                        <h4>{{ __('Items') }} ({{ $order->orderItems->count() }})</h4>
                        <div class="items-preview">
                            @foreach($order->orderItems->take(3) as $item)
                            <div class="item-preview">
                                <img src="{{ asset($item->product->image ?? 'images/default-product.svg') }}" alt="{{ $item->product->name }}">
                                <div class="item-info">
                                    <span class="item-name">{{ $item->product->name }}</span>
                                    <span class="item-quantity">x{{ $item->quantity }}</span>
                                </div>
                            </div>
                            @endforeach
                            @if($order->orderItems->count() > 3)
                                <div class="more-items">
                                    +{{ $order->orderItems->count() - 3 }} {{ __('more items') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="order-total">
                        <p class="total-label">{{ __('Total') }}</p>
                        <p class="total-amount">{{ number_format($order->total_cost, 0, '.', ',') }} {{ __('VND') }}</p>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="{{ route('customer.orders.details', $order->order_id) }}" class="btn-view-details">
                        <i class="fas fa-eye"></i>
                        {{ __('View Details') }}
                    </a>
                    @if($order->status === 'delivered')
                        <button class="btn-reorder">
                            <i class="fas fa-redo"></i>
                            {{ __('Reorder') }}
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="empty-orders">
            <div class="empty-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3>{{ __('No Orders Yet') }}</h3>
            <p>{{ __('You haven\'t placed any orders yet. Start shopping to see your order history here.') }}</p>
            <a href="{{ route('customer.categories') }}" class="btn-start-shopping">
                {{ __('Start Shopping') }}
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.orders-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.orders-header {
    text-align: center;
    margin-bottom: 50px;
}

.orders-header h2 {
    font-size: 36px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.orders-subtitle {
    font-size: 18px;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

/* Orders List */
.orders-list {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.order-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    padding: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

/* Order Header */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.order-number {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.order-date {
    color: #666;
    font-size: 14px;
}

/* Status Badges */
.order-status-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: #FFF3E0;
    color: #F57C00;
}

.status-confirmed {
    background: #E3F2FD;
    color: #1976D2;
}

.status-processing {
    background: #F3E5F5;
    color: #7B1FA2;
}

.status-shipped {
    background: #E8F5E8;
    color: #388E3C;
}

.status-delivered {
    background: #E8F5E8;
    color: #2E7D32;
}

.status-cancelled {
    background: #FFEBEE;
    color: #D32F2F;
}

/* Order Summary */
.order-summary {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.order-items h4 {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.items-preview {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.item-preview {
    display: flex;
    align-items: center;
    gap: 12px;
}

.item-preview img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
}

.item-info {
    flex: 1;
}

.item-name {
    display: block;
    font-size: 14px;
    color: #333;
    font-weight: 500;
}

.item-quantity {
    font-size: 12px;
    color: #666;
}

.more-items {
    font-size: 12px;
    color: #B88E2F;
    font-style: italic;
    margin-top: 5px;
}

/* Order Total */
.order-total {
    text-align: right;
}

.total-label {
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
}

.total-amount {
    font-size: 24px;
    font-weight: 600;
    color: #B88E2F;
}

/* Order Actions */
.order-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.btn-view-details,
.btn-reorder {
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-view-details {
    background: #B88E2F;
    color: white;
}

.btn-view-details:hover {
    background: #A67F2A;
}

.btn-reorder {
    background: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
}

.btn-reorder:hover {
    background: #e9ecef;
}

/* Empty State */
.empty-orders {
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    font-size: 80px;
    color: #ddd;
    margin-bottom: 30px;
}

.empty-orders h3 {
    font-size: 28px;
    color: #333;
    margin-bottom: 15px;
}

.empty-orders p {
    font-size: 16px;
    color: #666;
    margin-bottom: 30px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.btn-start-shopping {
    background: #B88E2F;
    color: white;
    padding: 15px 30px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: background 0.3s ease;
}

.btn-start-shopping:hover {
    background: #A67F2A;
}

/* Responsive */
@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .order-summary {
        flex-direction: column;
        gap: 20px;
    }
    
    .order-total {
        text-align: left;
    }
    
    .order-actions {
        justify-content: flex-start;
        flex-wrap: wrap;
    }
    
    .items-preview {
        max-height: 150px;
        overflow-y: auto;
    }
}
</style>
@endpush
