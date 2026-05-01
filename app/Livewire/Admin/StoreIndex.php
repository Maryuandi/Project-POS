<?php

namespace App\Livewire\Admin;

use App\Models\Store;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class StoreIndex extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    public function toggleActive($id)
    {
        $store = Store::findOrFail($id);
        $store->is_active = ! $store->is_active;
        $store->save();

        session()->flash('message', 'Status store berhasil diperbarui.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $stores = Store::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%')
                        ->orWhere('store_category', 'like', '%' . $this->search . '%')
                        ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByRaw('LOWER(name) asc')
            ->paginate(10);

        $storeGroups = $stores->getCollection()
            ->groupBy(function ($store) {
                $name = ltrim((string) $store->name);
                $firstChar = $name !== '' ? strtoupper(substr($name, 0, 1)) : '#';

                return preg_match('/[A-Z]/', $firstChar) ? $firstChar : '#';
            })
            ->sortKeys();

        return view('livewire.admin.store-index', [
            'stores' => $stores,
            'storeGroups' => $storeGroups,
        ]);
    }
}
