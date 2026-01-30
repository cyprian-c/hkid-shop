{{-- resources/views/admin/orders/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<h1 style="margin-bottom: 2rem;">Orders</h1>

<div style="margin-bottom: 1rem;">
    <a href="{{ route('admin.orders.index') }}" class="btn {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">All</a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn {{ request('status') == 'pending' ? 'btn-primary' : 'btn-secondary' }}">Pending</a>
    <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="btn {{ request('status') == 'paid' ? 'btn-primary' : 'btn-secondary' }}">Paid</a>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->customer_phone }}</td>
            <td>KSh {{ number_format($order->total) }}</td>
            <td><span class="badge badge-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td>
            <td><span class="badge badge-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span></td>
            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn-sm btn-primary">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->links() }}
@endsection