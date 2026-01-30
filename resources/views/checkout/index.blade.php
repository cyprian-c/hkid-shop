{{-- resources/views/checkout/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Checkout - Nairobi Fashion Store')

@section('styles')
<style>
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 3rem;
    }

    .checkout-form h2,
    .order-summary h2 {
        margin-bottom: 1.5rem;
        color: #2c3e50;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .order-summary {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 10px;
        height: fit-content;
    }

    .cart-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #ddd;
    }

    .cart-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .item-meta {
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    .order-totals {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 2px solid #ddd;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .total-row.grand-total {
        font-size: 1.3rem;
        font-weight: bold;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid #ddd;
    }

    .payment-methods {
        display: grid;
        gap: 1rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .checkout-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<h1 style="margin-bottom: 2rem;">Checkout</h1>

<div class="checkout-container">
    <div class="checkout-form">
        <h2>Delivery Details</h2>

        <form id="checkoutForm">
            @csrf
            <div class="form-group">
                <label for="customer_name">Full Name *</label>
                <input type="text" id="customer_name" name="customer_name" required>
            </div>

            <div class="form-group">
                <label for="customer_phone">Phone Number *</label>
                <input type="tel" id="customer_phone" name="customer_phone" placeholder="07XXXXXXXX" required>
            </div>

            <div class="form-group">
                <label for="customer_email">Email Address</label>
                <input type="email" id="customer_email" name="customer_email">
            </div>

            <div class="form-group">
                <label for="delivery_address">Delivery Address *</label>
                <textarea id="delivery_address" name="delivery_address" placeholder="Enter your full delivery address" required></textarea>
            </div>

            <h2>Select Payment Method</h2>
            <div class="payment-methods">
                <button type="button" class="btn btn-success" onclick="processPayment('mpesa')">
                    📱 Pay with M-Pesa (KSh {{ number_format($total) }})
                </button>
                <button type="button" class="btn btn-primary" onclick="processPayment('whatsapp')">
                    💬 Order via WhatsApp
                </button>
            </div>
        </form>
    </div>

    <div class="order-summary">
        <h2>Order Summary</h2>

        @foreach($cart as $id => $item)
        <div class="cart-item">
            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
            <div class="item-details">
                <div class="item-name">{{ $item['name'] }}</div>
                <div class="item-meta">
                    Qty: {{ $item['quantity'] }}
                    @if($item['size']) | Size: {{ $item['size'] }} @endif
                    @if($item['color']) | Color: {{ $item['color'] }} @endif
                </div>
                <div style="font-weight: bold; margin-top: 0.25rem;">
                    KSh {{ number_format($item['price'] * $item['quantity']) }}
                </div>
            </div>
        </div>
        @endforeach

        <div class="order-totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>KSh {{ number_format($subtotal) }}</span>
            </div>
            <div class="total-row">
                <span>Delivery Fee:</span>
                <span>KSh {{ number_format($deliveryFee) }}</span>
            </div>
            <div class="total-row grand-total">
                <span>Total:</span>
                <span>KSh {{ number_format($total) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function processPayment(method) {
        const form = document.getElementById('checkoutForm');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);

        if (method === 'mpesa') {
            fetch('{{ route("checkout.mpesa") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('M-Pesa payment request sent! Please check your phone.');
                        window.location.href = data.redirect;
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
        } else {
            form.action = '{{ route("checkout.whatsapp") }}';
            form.method = 'POST';
            form.submit();
        }
    }
</script>
@endsection