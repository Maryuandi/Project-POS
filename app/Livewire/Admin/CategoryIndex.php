<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

use Livewire\Attributes\Url;

class CategoryIndex extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();
        session()->flash('message', 'Status kategori berhasil diperbarui.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.category-index', [
            'categories' => $categories
        ]);
    }
}
