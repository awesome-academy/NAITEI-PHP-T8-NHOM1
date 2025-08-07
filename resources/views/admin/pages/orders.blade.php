@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Order Management</h2>
            <div>
                <select class="form-control" style="width: auto; display: inline-block; margin-right: 10px;">
                    <option>All Statuses</option>
                    <option>Pending</option>
                    <option>Approved</option>
                    <option>Reject</option>
                    <option>Delivered</option>
                    <option>Cancelled</option>
                </select>
            </div>
        </div>
        <div style="padding: 20px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->order_id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ number_format($order->total_amount) }} VNĐ</td>
                        <td>
                            @php
                                $latestStatus = $order->statusOrders()
                                    ->orderBy('date', 'desc')
                                    ->first();
                                
                                $status = $latestStatus ? $latestStatus->action_type : 'pending';
                                
                                $statusClasses = [
                                    'pending' => 'status-pending',
                                    'approved' => 'status-approved',
                                    'reject' => 'status-reject',
                                    'delivered' => 'status-delivered',
                                    'cancelled' => 'status-cancelled'
                                ];
                                
                                $statusTexts = [
                                    'pending' => 'Pending',
                                    'approved' => 'Approved',
                                    'reject' => 'Rejected',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled'
                                ];
                                
                                $statusClass = $statusClasses[$status] ?? 'status-pending';
                                $statusText = $statusTexts[$status] ?? 'Pending';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            @if($status == 'pending')
                                <button class="btn btn-success btn-sm" onclick="adminPanel.approveOrder('{{ $order->order_id }}')">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="adminPanel.rejectOrder('{{ $order->order_id }}')">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                                <button class="btn btn-secondary btn-sm" onclick="adminPanel.viewOrderDetails('{{ $order->order_id }}')">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                            @else
                                <button class="btn btn-secondary btn-sm" onclick="adminPanel.viewOrderDetails('{{ $order->order_id }}')">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                                <span class="text-muted">
                                    <small>({{ $statusText }})</small>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
