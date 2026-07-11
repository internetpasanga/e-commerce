<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $revenueThisMonth = (float) Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'cancelled')
            ->sum('grand_total');

        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $customerCount = User::where('is_admin', false)->count();
        $activeProductCount = Product::where('status', true)->count();

        $chartData = $this->revenueChartData();

        $recentOrders = Order::latest()->take(8)->get();

        $lowStockThreshold = (int) Setting::get('low_stock_threshold', 5);
        $lowStockProducts = Product::where('stock', '<=', $lowStockThreshold)
            ->orderBy('stock')
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'revenueThisMonth' => $revenueThisMonth,
            'ordersThisMonth' => $ordersThisMonth,
            'customerCount' => $customerCount,
            'activeProductCount' => $activeProductCount,
            'chartData' => $chartData,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    /**
     * @return array<int, array{date: string, label: string, total: float}>
     */
    private function revenueChartData(): array
    {
        $start = now()->subDays(29)->startOfDay();

        $orders = Order::where('created_at', '>=', $start)
            ->where('status', '!=', 'cancelled')
            ->get(['created_at', 'grand_total']);

        $byDay = $orders->groupBy(fn (Order $order) => $order->created_at->format('Y-m-d'))
            ->map(fn ($dayOrders) => (float) $dayOrders->sum('grand_total'));

        $days = [];

        for ($i = 0; $i < 30; $i++) {
            $date = $start->copy()->addDays($i);
            $key = $date->format('Y-m-d');

            $days[] = [
                'date' => $key,
                'label' => $date->format('d M'),
                'total' => $byDay->get($key, 0.0),
            ];
        }

        return $days;
    }
}
