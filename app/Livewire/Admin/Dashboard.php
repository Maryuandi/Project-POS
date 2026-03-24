<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();
        $endOfYesterday = now()->subDay()->endOfDay();

        // Today's metrics
        $todayRevenue = Sale::where('sold_at', '>=', $today)->sum('amount_paid');
        $todayOrders = Sale::where('sold_at', '>=', $today)->count();
        $todayAvg = $todayOrders > 0 ? $todayRevenue / $todayOrders : 0;

        // Yesterday's metrics for comparison
        $yesterdayRevenue = Sale::whereBetween('sold_at', [$yesterday, $endOfYesterday])->sum('amount_paid');
        $yesterdayOrders = Sale::whereBetween('sold_at', [$yesterday, $endOfYesterday])->count();

        // Percentage changes
        $revenueChange = $yesterdayRevenue > 0 ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 1) : 0;
        $ordersChange = $yesterdayOrders > 0 ? round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100, 1) : 0;

        // Low stock count
        $lowStockCount = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        // Top selling products (today)
        $topProducts = SaleItem::select('product_id', DB::raw('SUM(qty) as total_sold'))
            ->whereHas('sale', fn($q) => $q->where('sold_at', '>=', $today))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->with('product:id,name,code,image_path')
            ->get();

        // Recent transactions
        $recentSales = Sale::with('cashier:id,name')
            ->orderByDesc('sold_at')
            ->limit(5)
            ->get();

        // Installment summary
        $pendingInstallments = Sale::where('status', 'installment')->count();
        $totalAmountDue = Sale::where('status', 'installment')->sum('amount_due');

        // Upcoming due installments (next 3 days)
        $upcomingDueInstallments = Sale::where('status', 'installment')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfDay(), now()->addDays(3)->endOfDay()])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('livewire.admin.dashboard', compact(
            'todayRevenue', 'todayOrders', 'todayAvg',
            'revenueChange', 'ordersChange',
            'lowStockCount', 'outOfStockCount',
            'topProducts', 'recentSales',
            'pendingInstallments', 'totalAmountDue',
            'upcomingDueInstallments'
        ));
    }
}
