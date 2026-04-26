<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $filterStatus = 'all';

    public $confirmingProductDeletion = false;
    public $productToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->productToDelete = Product::findOrFail($id);
        $this->confirmingProductDeletion = true;
    }

    public function deleteProduct()
    {
        if ($this->productToDelete) {
            $product = Product::find($this->productToDelete->id);
            if ($product) {
                $product->delete();
                session()->flash('message', 'Produk berhasil dihapus.');
            }
            $this->confirmingProductDeletion = false;
            $this->productToDelete = null;
        }
    }

    public function cancelDelete()
    {
        $this->confirmingProductDeletion = false;
        $this->productToDelete = null;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus === 'available', function ($query) {
                $query->where('stock', '>', 10);
            })
            ->when($this->filterStatus === 'low_stock', function ($query) {
                $query->whereBetween('stock', [1, 10]);
            })
            ->when($this->filterStatus === 'out_of_stock', function ($query) {
                $query->where('stock', 0);
            })
            ->latest()
            ->paginate(20);

        return view('livewire.admin.product-index', [
            'products' => $products,
            'unpaidInstallments' => \App\Models\Sale::with('cashier')->where('status', 'installment')->orderByDesc('created_at')->get(),
        ]);
    }
}
