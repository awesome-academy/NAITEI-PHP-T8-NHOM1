@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">{{ __('Order Management') }}</h2>
            <div>
                <select class="form-control" style="width: auto; display: inline-block; margin-right: 10px;">
                    <option>{{ __('All Statuses') }}</option>
                    <option>{{ __('Pending') }}</option>
                    <option>{{ __('Approved') }}</option>
                    <option>{{ __('Rejected') }}</option>
                    <option>{{ __('Delivered') }}</option>
                    <option>{{ __('Cancelled') }}</option>
                </select>
            </div>
        </div>
        <div style="padding: 20px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Order ID') }}</th>
                        <th>{{ __('Customer') }}</th>
                        <th>{{ __('Order Date') }}</th>
                        <th>{{ __('Total Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->order_id }}</td>
                        <td>{{ $order->user->user_name ?? $order->user->name ?? __('N/A') }}</td>
                        <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') : __('N/A') }}</td>
                        <td>{{ number_format($order->total_cost) }} {{ __('VNĐ') }}</td>
                        <td>
                            @php
                                $status = $order->status ?? 'pending';
                                $statusClasses = [
                                    'pending' => 'status-pending',
                                    'approved' => 'status-approved',
                                    'rejected' => 'status-reject',
                                    'delivered' => 'status-delivered',
                                    'cancelled' => 'status-cancelled'
                                ];
                                $statusTexts = [
                                    'pending' => __('Pending'),
                                    'approved' => __('Approved'),
                                    'rejected' => __('Rejected'),
                                    'delivered' => __('Delivered'),
                                    'cancelled' => __('Cancelled')
                                ];
                                $statusClass = $statusClasses[$status] ?? 'status-pending';
                                $statusText = $statusTexts[$status] ?? __('Pending');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.status.update', $order->order_id) }}" method="POST" style="display:inline-flex; gap:8px; align-items:center;">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="pending" {{ $status==='pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="approved" {{ $status==='approved' ? 'selected' : '' }}>{{ __('Approve') }}</option>
                                    <option value="rejected" {{ $status==='rejected' ? 'selected' : '' }}>{{ __('Reject') }}</option>
                                    <option value="delivered" {{ $status==='delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                                    <option value="cancelled" {{ $status==='cancelled' ? 'selected' : '' }}>{{ __('Cancel') }}</option>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-save"></i> {{ __('Update') }}
                                </button>
                            </form>
                                <button class="btn btn-secondary btn-sm view-order-details-btn" data-order-id="{{ $order->order_id }}">
                                    <i class="fas fa-eye"></i> {{ __('View Details') }}
                                </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">{{ __('No orders found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Handle View Details button click
        document.querySelectorAll('.view-order-details-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const orderId = e.currentTarget.getAttribute('data-order-id');
                if (!orderId) {
                    console.error('Order ID not found for view details button.');
                    return;
                }
                
                fetch(`/admin/orders/${orderId}/details`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Order details received:', data);
                    const order = data.order;
                    const customerName = data.customer_name;
                    const orderItems = data.order_items;
                    const statusHistory = data.status_history;
        
                    // Populate general order info
                    document.getElementById('order_detail_id').value = `#${order.order_id}`;
                    document.getElementById('order_detail_customer_name').value = customerName;
                    document.getElementById('order_detail_date').value = new Date(order.order_date).toLocaleDateString();
                    document.getElementById('order_detail_total_amount').value = `${order.total_cost.toLocaleString()} VNĐ`;
                    document.getElementById('order_detail_status').value = order.status;
        
                    // Populate order items table
                    const itemsTableBody = document.querySelector('#order_detail_items_table tbody');
                    itemsTableBody.innerHTML = ''; // Clear previous items
                    orderItems.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.product_name}</td>
                                <td>${item.quantity}</td>
                                <td>${item.price.toLocaleString()} VNĐ</td>
                                <td>${item.subtotal.toLocaleString()} VNĐ</td>
                            </tr>
                        `;
                        itemsTableBody.insertAdjacentHTML('beforeend', row);
                    });
        
                    adminPanel.openModal('viewOrderDetailsModal');
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    alert('{{ __('Failed to load order details.') }}');
                });
            });
        });
    });
</script>
@endsection
