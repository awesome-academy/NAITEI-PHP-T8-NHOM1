@extends('admin.layouts.app')

@section('content')
<div class="content-section active">
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Feedbacks Management</h2>
        </div>
        <div style="padding: 20px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Review Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                    <tr>
                        <td>#{{ $feedback->feedback_id }}</td>
                        <td>{{ $feedback->user->name ?? 'N/A' }}</td>
                        <td>{{ $feedback->product->name ?? 'N/A' }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $feedback->rating)
                                    <i class="fas fa-star" style="color: #ffc107;"></i>
                                @else
                                    <i class="far fa-star" style="color: #ccc;"></i>
                                @endif
                            @endfor
                        </td>
                        <td>{{ Str::limit($feedback->comment, 50) }}</td>
                        <td>{{ $feedback->created_at ? $feedback->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            <button class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No feedbacks found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
