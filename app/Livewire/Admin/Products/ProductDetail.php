<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\StockMovement;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class ProductDetail extends Component
{
    use WithPagination;

    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $stockMovements = StockMovement::with(['createdBy'])
            ->where('product_id', $this->product->id)
            ->latest('occurred_at')
            ->paginate(15);

        return view('livewire.admin.products.product-detail', [
            'stockMovements' => $stockMovements,
        ]);
    }
}
