<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;
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
    public $filterStore = '';

    #[Url]
    public $filterStatus = 'all';

    public $confirmingProductDeletion = false;
    public $productToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStore()
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
                if ($product->image_path && ! str_starts_with($product->image_path, 'http')) {
                    Storage::disk('public')->delete($product->image_path);
                }
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
        $products = Product::with('store')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%')
                        ->orWhereHas('store', function ($qs) {
                            $qs->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterStore, function ($query) {
                $query->where('store_id', $this->filterStore);
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
            'storesList' => Store::orderBy('name')->get(),
            'unpaidInstallments' => \App\Models\Sale::with('cashier')->where('status', 'installment')->orderByDesc('created_at')->get(),
        ]);
    }
}
