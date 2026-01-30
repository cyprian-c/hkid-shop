{{-- resources/views/admin/products/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1>Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Add Product</a>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td><img src="{{ $product->main_image }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;"></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>KSh {{ number_format($product->price) }}</td>
            <td>{{ $product->stock_quantity }}</td>
            <td><span class="badge badge-{{ $product->is_active ? 'success' : 'danger' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td class="action-buttons">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}
@endsection