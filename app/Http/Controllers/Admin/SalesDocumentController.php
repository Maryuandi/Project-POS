<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SalesDocumentController extends Controller
{
    public function invoice(Sale $sale)
    {
        $sale->load(['cashier', 'store', 'saleItems.product', 'installmentPayments']);

        return view('admin.sales.documents.invoice', [
            'sale' => $sale,
            'title' => 'Invoice - ' . ($sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT)),
        ]);
    }

    public function salesHistoryReport(Request $request)
    {
        $filters = [
            'search' => (string) $request->input('search', ''),
            'filterStatus' => (string) $request->input('filterStatus', ''),
            'filterStore' => (string) $request->input('filterStore', ''),
            'filterDate' => (string) $request->input('filterDate', 'semua'),
            'startDate' => (string) $request->input('startDate', ''),
            'endDate' => (string) $request->input('endDate', ''),
        ];

        $selectAll = filter_var($request->input('select_all', false), FILTER_VALIDATE_BOOL);
        $saleIds = array_values(array_filter(array_map('intval', (array) $request->input('sale_ids', []))));

        $query = Sale::historyBase();
        $this->applyFilters($query, $filters);

        if (!$selectAll && count($saleIds) > 0) {
            $query->whereIn('id', $saleIds);
        }

        if (!$selectAll && count($saleIds) === 0) {
            $sales = collect();
        } else {
            $sales = $query->latestSold()->get();
        }

        $sales->transform(function ($sale) {
            $sale->profit_amount = $sale->saleItems->sum(function ($item) {
                return ((float) $item->unit_price - (float) ($item->product->cost ?? 0)) * $item->qty;
            });

            return $sale;
        });

        $totalTransactions = $sales->count();
        $totalRevenue = (float) $sales->sum('amount_paid');
        $totalProfit = (float) $sales->sum('profit_amount');
        $totalProductsSold = (int) $sales->sum(function ($sale) {
            return $sale->saleItems->sum('qty');
        });

        return view('admin.sales.documents.sales-history-report', [
            'sales' => $sales,
            'filters' => $filters,
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'totalProfit' => $totalProfit,
            'totalProductsSold' => $totalProductsSold,
            'generatedAt' => now(),
            'title' => 'Sales Report',
        ]);
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        $search = trim($filters['search'] ?? '');
        $statusFilter = $filters['filterStatus'] ?? '';
        $storeFilter = $filters['filterStore'] ?? '';
        $filterDate = $filters['filterDate'] ?? 'semua';
        $startDate = $filters['startDate'] ?? '';
        $endDate = $filters['endDate'] ?? '';

        if ($search !== '') {
            $searchTerm = strtolower($search);
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(invoice_no) LIKE ?', ['%' . $searchTerm . '%'])
                    ->orWhereHas('cashier', function ($q2) use ($searchTerm) {
                        $q2->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                    })
                    ->orWhereHas('store', function ($q3) use ($searchTerm) {
                        $q3->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                            ->orWhereRaw('LOWER(code) LIKE ?', ['%' . $searchTerm . '%']);
                    });
            });
        }

        if ($statusFilter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($statusFilter === 'installment') {
            $query->where('status', 'installment');
        }

        if ($storeFilter !== '') {
            $query->whereHas('store', function ($q) use ($storeFilter) {
                $q->where('store_category', $storeFilter);
            });
        }

        if ($filterDate === 'harian') {
            $query->whereDate('sold_at', now()->toDateString());
        } elseif ($filterDate === 'mingguan') {
            $query->where('sold_at', '>=', now()->subDays(7)->startOfDay());
        } elseif ($filterDate === 'bulanan') {
            $query->whereMonth('sold_at', now()->month)
                ->whereYear('sold_at', now()->year);
        } elseif ($filterDate === 'custom') {
            if ($startDate !== '') {
                $query->whereDate('sold_at', '>=', $startDate);
            }
            if ($endDate !== '') {
                $query->whereDate('sold_at', '<=', $endDate);
            }
        }
    }
}
