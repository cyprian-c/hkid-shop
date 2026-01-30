<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = 300; // Fixed delivery fee
        $total = $subtotal + $deliveryFee;

        return view('checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    public function processWhatsapp(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string'
        ]);

        $cart = session()->get('cart', []);
        $order = $this->createOrder($validated, $cart, 'whatsapp');

        // Build WhatsApp message
        $message = "*New Order - {$order->order_number}*\n\n";
        $message .= "👤 Customer: {$order->customer_name}\n";
        $message .= "📱 Phone: {$order->customer_phone}\n";
        $message .= "📍 Address: {$order->delivery_address}\n\n";
        $message .= "*Items:*\n";

        foreach ($order->items as $item) {
            $message .= "• {$item->product_name} x{$item->quantity}";
            if ($item->size) $message .= " (Size: {$item->size})";
            if ($item->color) $message .= " (Color: {$item->color})";
            $message .= " - KSh " . number_format($item->subtotal) . "\n";
        }

        $message .= "\n💰 Total: KSh " . number_format($order->total);

        $whatsappNumber = '254700000000'; // Your business number
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

        session()->forget('cart');

        return redirect()->away($whatsappUrl);
    }

    public function processMpesa(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'delivery_address' => 'required|string'
        ]);

        $cart = session()->get('cart', []);
        $order = $this->createOrder($validated, $cart, 'mpesa');

        // Call M-Pesa STK Push
        $response = $this->initiateSTKPush($order);

        if ($response['success']) {
            session()->forget('cart');
            return redirect()->route('order.success', $order->id)
                ->with('success', 'Payment request sent. Check your phone.');
        }

        return back()->with('error', $response['message']);
    }

    private function createOrder($validated, $cart, $paymentMethod)
    {
        return DB::transaction(function () use ($validated, $cart, $paymentMethod) {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $deliveryFee = 300;
            $total = $subtotal + $deliveryFee;

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,
                'delivery_address' => $validated['delivery_address'],
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'whatsapp' ? 'pending' : 'pending',
                'order_status' => 'pending'
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_sku' => Product::find($item['product_id'])->sku,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Reduce stock
                $product = Product::find($item['product_id']);
                $product->decrement('stock_quantity', $item['quantity']);
            }

            return $order;
        });
    }

    private function initiateSTKPush($order)
    {
        // M-Pesa implementation here (similar to previous code)
        // Return ['success' => true/false, 'message' => '...']
        return ['success' => true, 'message' => 'STK Push sent'];
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }
}
