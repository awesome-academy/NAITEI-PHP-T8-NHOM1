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
                    <option>{{ __('Reject') }}</option>
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
                                    'pending' => __('Pending'),
                                    'approved' => __('Approved'),
                                    'reject' => __('Rejected'),
                                    'delivered' => __('Delivered'),
                                    'cancelled' => __('Cancelled')
                                ];
                                
                                $statusClass = $statusClasses[$status] ?? 'status-pending';
                                $statusText = $statusTexts[$status] ?? __('Pending');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            @if($status == 'pending')
                                <button class="btn btn-success btn-sm" onclick="adminPanel.approveOrder('{{ $order->order_id }}')">
                                    <i class="fas fa-check"></i> {{ __('Approve') }}
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="adminPanel.rejectOrder('{{ $order->order_id }}')">
                                    <i class="fas fa-times"></i> {{ __('Reject') }}
                                </button>
                                <button class="btn btn-secondary btn-sm" onclick="adminPanel.viewOrderDetails('{{ $order->order_id }}')">
                                    <i class="fas fa-eye"></i> {{ __('View Details') }}
                                </button>
                            @else
                                <button class="btn btn-secondary btn-sm" onclick="adminPanel.viewOrderDetails('{{ $order->order_id }}')">
                                    <i class="fas fa-eye"></i> {{ __('View Details') }}
                                </button>
                                <span class="text-muted">
                                    <small>({{ $statusText }})</small>
                                </span>
                            @endif
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
