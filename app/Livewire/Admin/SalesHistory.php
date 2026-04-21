<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class SalesHistory extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $filterStatus = '';

    #[Url]
    public $filterDate = 'semua';

    #[Url]
    public $startDate = '';

    #[Url]
    public $endDate = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Sale::with(['cashier', 'store']);

        $search = $this->search;
        $statusFilter = $this->filterStatus;
        $filterDate = $this->filterDate;
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        if (!empty($search)) {
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

        if ($filterDate === 'harian') {
            $query->whereDate('sold_at', now()->toDateString());
        } elseif ($filterDate === 'mingguan') {
            $query->where('sold_at', '>=', now()->subDays(7)->startOfDay());
        } elseif ($filterDate === 'bulanan') {
            $query->whereMonth('sold_at', now()->month)
                  ->whereYear('sold_at', now()->year);
        } elseif ($filterDate === 'custom') {
            if (!empty($startDate)) {
                $query->whereDate('sold_at', '>=', $startDate);
            }
            if (!empty($endDate)) {
                $query->whereDate('sold_at', '<=', $endDate);
            }
        }

        $metricsQuery = clone $query;
        $sales = $query->orderBy('sold_at', 'desc')->paginate(10);

        // Metrics calculations (filtered)
        $totalRevenue = (clone $metricsQuery)->sum('amount_paid');
        $totalTransactions = (clone $metricsQuery)->count();
        $totalProductsSold = \App\Models\SaleItem::whereIn('sale_id', (clone $metricsQuery)->select('id'))->sum('qty');

        // Upcoming due installments (next 3 days)
        $upcomingDueInstallments = Sale::where('status', 'installment')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfDay(), now()->addDays(3)->endOfDay()])
            ->orderBy('due_date', 'asc')
            ->get();

        // Unpaid installments for reminder modal
        $unpaidInstallments = Sale::with('cashier')
            ->where('status', 'installment')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.admin.sales-history', [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'totalTransactions' => $totalTransactions,
            'totalProductsSold' => $totalProductsSold,
            'upcomingDueInstallments' => $upcomingDueInstallments,
            'unpaidInstallments' => $unpaidInstallments,
            'search' => $search,
            'filterStatus' => $statusFilter,
            'filterDate' => $filterDate,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->layout('layouts.admin', ['title' => 'Sales History - Project POS']);
    }
}
