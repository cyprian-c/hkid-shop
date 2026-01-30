@extends('layouts.app')

@section('title', 'Home - Nairobi Fashion Store')

@section('styles')
<style>
    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 4rem 2rem;
        text-align: center;
        border-radius: 10px;
        margin-bottom: 3rem;
    }

    .hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
    }

    .hero .btn {
        font-size: 1.2rem;
        padding: 1rem 2rem;
    }

    .section-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: #2c3e50;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-bottom: 4rem;
    }

    .category-card {
        background: #f8f9fa;
        padding: 2rem;
        text-align: center;
        border-radius: 10px;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .category-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .category-name {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .product-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
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

    .product-name {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .product-category {
        color: #7f8c8d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-size: 1.5rem;
        color: #27ae60;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 4rem 0;
    }

    .feature {
        text-align: center;
        padding: 2rem;
    }

    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .feature h3 {
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }
</style>
@endsection

@section('content')
<div class="hero">
    <h1>Welcome to Nairobi Fashion</h1>
    <p>Discover the latest trends in African fashion</p>
    <a href="{{ route('shop.index') }}" class="btn btn-success">Shop Now</a>
</div>

@if($categories->count() > 0)
<h2 class="section-title">Shop by Category</h2>
<div class="categories-grid">
    @foreach($categories as $category)
    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" style="text-decoration: none; color: inherit;">
        <div class="category-card">
            <div class="category-icon">👕</div>
            <div class="category-name">{{ $category->name }}</div>
            <p>{{ $category->products_count }} items</p>
        </div>
    </a>
    @endforeach
</div>
@endif

@if($featuredProducts->count() > 0)
<h2 class="section-title">Featured Products</h2>
<div class="products-grid">
    @foreach($featuredProducts as $product)
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

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Add to Cart</button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div style="text-align: center;">
    <a href="{{ route('shop.index') }}" class="btn btn-primary">View All Products</a>
</div>
@endif

<div class="features">
    <div class="feature">
        <div class="feature-icon">🚚</div>
        <h3>Free Delivery</h3>
        <p>Free delivery within Nairobi for orders above KSh 5,000</p>
    </div>
    <div class="feature">
        <div class="feature-icon">💳</div>
        <h3>Secure Payment</h3>
        <p>Pay safely via M-Pesa or WhatsApp</p>
    </div>
    <div class="feature">
        <div class="feature-icon">🔄</div>
        <h3>Easy Returns</h3>
        <p>7-day return policy on all items</p>
    </div>
    <div class="feature">
        <div class="feature-icon">⭐</div>
        <h3>Quality Guaranteed</h3>
        <p>100% authentic products</p>
    </div>
</div>
@endsection