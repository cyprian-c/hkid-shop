@extends('layouts.app')

@section('title', 'Shop - Nairobi Fashion Store')

@section('styles')
<style>
    .shop-container {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 2rem;
    }

    .sidebar {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        height: fit-content;
    }

    .sidebar h3 {
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    .category-list {
        list-style: none;
    }

    .category-list li {
        margin-bottom: 0.5rem;
    }

    .category-list a {
        color: #333;
        text-decoration: none;
        display: block;
        padding: 0.5rem;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .category-list a:hover,
    .category-list a.active {
        background: #e74c3c;
        color: #fff;
    }

    .products-section h2 {
        margin-bottom: 2rem;
        color: #2c3e50;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .product-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-category {
        color: #7f8c8d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .product-name {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .product-price {
        font-size: 1.5rem;
        color: #27ae60;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .stock-status {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .in-stock {
        color: #27ae60;
    }

    .out-of-stock {
        color: #e74c3c;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
    }

    .pagination a:hover {
        background: #e74c3c;
        color: #fff;
    }

    .pagination .active {
        background: #3498db;
        color: #fff;
    }

    @media (max-width: 768px) {
        .shop-container {
            grid-template-columns: 1fr;
        }

        .sidebar {
            margin-bottom: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="shop-container">
    <aside class="sidebar">
        <h3>Categories</h3>
        <ul class="category-list">
            <li>
                <a href="{{ route('shop.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                    All Products
                </a>
            </li>
            @foreach($categories as $category)
            <li>
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                    class="{{ request('category') == $category->slug ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </aside>

    <div class="products-section">
        <h2>
            @if(request('search'))
            Search Results for "{{ request('search') }}"
            @elseif(request('category'))
            {{ $categories->firstWhere('slug', request('category'))->name ?? 'Products' }}
            @else
            All Products
            @endif
        </h2>

        @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                <a href="{{ route('shop.show', $product->slug) }}">
                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="product-image">
                </a>
                <div class="product-info">
                    <div class="product-category">{{ $product->category->name }}</div>
                    <a href="{{ route('shop.show', $product->slug) }}" style="text-decoration: none; color: inherit;">
                        <h3 class="product-name">{{ $product->name }}</h3>
                    </a>
                    <div class="product-price">KSh {{ number_format($product->price) }}</div>

                    <div class="stock-status {{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                        {{ $product->stock_quantity > 0 ? '✓ In Stock' : '✗ Out of Stock' }}
                    </div>

                    @if($product->stock_quantity > 0)
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Add to Cart</button>
                    </form>
                    @else
                    <button class="btn btn-primary" style="width: 100%; opacity: 0.6;" disabled>Out of Stock</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
        @else
        <p style="text-align: center; padding: 3rem; color: #7f8c8d;">
            No products found. <a href="{{ route('shop.index') }}">View all products</a>
        </p>
        @endif
    </div>
</div>
@endsection