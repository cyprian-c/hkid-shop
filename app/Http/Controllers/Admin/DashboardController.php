<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => Order::where('payment_status', 'paid')->sum('total'),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'total_products' => Product::count(),
            'low_stock' => Product::where('stock_quantity', '<', 10)->count(),
        ];

        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get();

        $salesByMonth = Order::where('payment_status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'salesByMonth', 'topProducts'));
    }
}
