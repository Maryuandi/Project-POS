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

        // Total products sold (today)
        $totalProductsSold = SaleItem::whereHas('sale', fn($q) => $q->where('sold_at', '>=', $today))->sum('qty');

        // Chart data: Daily (last 7 days)
        $dailyChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'label' => $date->translatedFormat('d M'),
                'value' => (float) Sale::whereDate('sold_at', $date->toDateString())->sum('amount_paid'),
            ];
        });

        // Chart data: Monthly (Current Year Months)
        $monthlyChart = collect(range(1, 12))->map(function ($month) {
            $date = \Carbon\Carbon::create(now()->year, $month, 1);
            return [
                'label' => $date->translatedFormat('F'),
                'value' => (float) Sale::whereYear('sold_at', now()->year)
                    ->whereMonth('sold_at', $month)
                    ->sum('amount_paid'),
            ];
        });

        // Chart data: Yearly (From 2024 onwards)
        $currentYear = now()->year;
        $yearlyChart = collect(range(2024, $currentYear + 1))->map(function ($year) {
            return [
                'label' => (string) $year,
                'value' => (float) Sale::whereYear('sold_at', $year)->sum('amount_paid'),
            ];
        });

        return view('livewire.admin.dashboard', compact(
            'todayRevenue', 'todayOrders', 'todayAvg',
            'revenueChange', 'ordersChange',
            'lowStockCount', 'outOfStockCount',
            'topProducts', 'recentSales',
            'pendingInstallments', 'totalAmountDue',
            'upcomingDueInstallments', 'totalProductsSold',
            'dailyChart', 'monthlyChart', 'yearlyChart'
        ));
    }
}
