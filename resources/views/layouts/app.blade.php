<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nairobi Fashion Store')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        /* Header Styles - Black Background */
        header {
            background: #000;
            color: #fff;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
        }

        .logo:hover {
            color: #e74c3c;
        }

        .header-actions {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .search-box {
            display: flex;
        }

        .search-box input {
            padding: 0.5rem 1rem;
            border: 1px solid #444;
            background: #222;
            color: #fff;
            outline: none;
            min-width: 250px;
        }

        .search-box button {
            padding: 0.5rem 1rem;
            background: #e74c3c;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .cart-icon {
            position: relative;
            color: #fff;
            text-decoration: none;
            font-size: 1.2rem;
            padding: 0.5rem 1rem;
            background: #e74c3c;
            border-radius: 5px;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #fff;
            color: #e74c3c;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }

        nav {
            border-top: 1px solid #333;
            padding-top: 1rem;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #e74c3c;
        }

        /* Main Content - White Background */
        main {
            background: #fff;
            min-height: calc(100vh - 200px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 20px;
        }

        /* Footer Styles - Black Background */
        footer {
            background: #000;
            color: #fff;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #e74c3c;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer-section a:hover {
            color: #e74c3c;
        }

        .footer-bottom {
            text-align: center;
            padding: 2rem 0 1rem;
            border-top: 1px solid #333;
            margin-top: 2rem;
            color: #888;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #3498db;
            color: #fff;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-success {
            background: #27ae60;
            color: #fff;
        }

        .btn-success:hover {
            background: #229954;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-top {
                flex-direction: column;
                gap: 1rem;
            }

            .search-box input {
                min-width: 200px;
            }

            nav ul {
                flex-direction: column;
                gap: 0.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <header>
        <div class="header-container">
            <div class="header-top">
                <a href="{{ route('home') }}" class="logo">
                    🛍️ Nairobi Fashion
                </a>

                <div class="header-actions">
                    <form action="{{ route('shop.index') }}" method="GET" class="search-box">
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                        <button type="submit">Search</button>
                    </form>

                    <a href="{{ route('checkout.index') }}" class="cart-icon">
                        🛒 Cart
                        @php
                        $cartCount = collect(session('cart', []))->sum('quantity');
                        @endphp
                        @if($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    @auth
                    @if(auth()->user()->is_admin)
                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background:none;border:none;color:#fff;cursor:pointer;">Logout</button>
                        </form>
                    </li>
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Your trusted source for quality fashion in Nairobi. We deliver style right to your doorstep.</p>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#">Delivery Information</a></li>
                    <li><a href="#">Returns Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>📱 Phone: +254 700 000 000</p>
                <p>📧 Email: info@nairobifashion.co.ke</p>
                <p>📍 Location: Nairobi, Kenya</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Nairobi Fashion Store. All rights reserved.</p>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>