{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<h1 style="margin-bottom: 2rem;">Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-info">
            <div class="stat-value">KSh {{ number_format($stats['total_sales']) }}</div>
            <div class="stat-label">Total Sales</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['pending_orders'] }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">👕</div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_products'] }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⚠️</div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['low_stock'] }}</div>
            <div class="stat-label">Low Stock Items</div>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <h2>Recent Orders</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>KSh {{ number_format($order->total) }}</td>
                    <td><span class="badge badge-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="dashboard-card">
        <h2>Top Selling Products</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Orders</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->order_items_count }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection