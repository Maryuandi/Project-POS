<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class SalesHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $sales = Sale::with('cashier')->orderBy('sold_at', 'desc')->paginate(10);

        // Metrics calculations
        $totalRevenue = Sale::sum('amount_paid');
        $totalTransactions = Sale::count();
        $totalProductsSold = \App\Models\SaleItem::sum('qty');

        return view('livewire.admin.sales-history', [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'totalTransactions' => $totalTransactions,
            'totalProductsSold' => $totalProductsSold
        ])->layout('layouts.admin', ['title' => 'Sales History - Project POS']);
    }
}
