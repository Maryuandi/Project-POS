<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(distributor) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'archived') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:products,code',
            'distributor' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:10240',
            'image_path' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validatedData['image']);

        $product = Product::create($validatedData);

        if ($product->stock > 0) {
            \App\Models\StockMovement::create([
                'product_id' => $product->id,
                'type' => 'IN',
                'qty_change' => $product->stock,
                'reference_type' => 'adjustment',
                'reason' => $request->filled('notes') ? $request->notes : 'Stok awal produk baru',
                'occurred_at' => now(),
                'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
            ]);
        }

        return redirect()->route('admin.products.index')->with('message', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'distributor' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:10240',
            'image_path' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validatedData['image']);

        $oldStock = $product->stock;
        $product->update($validatedData);
        $newStock = $product->stock;

        if ($oldStock != $newStock) {
            $diff = $newStock - $oldStock;
            \App\Models\StockMovement::create([
                'product_id' => $product->id,
                'type' => $diff > 0 ? 'IN' : 'OUT',
                'qty_change' => abs($diff),
                'reference_type' => 'adjustment',
                'reason' => $request->filled('notes') ? $request->notes : 'Update data produk (ubah stok manual)',
                'occurred_at' => now(),
                'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
            ]);
        }

        return redirect()->route('admin.products.index')->with('message', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('message', 'Product deleted successfully.');
    }
}
