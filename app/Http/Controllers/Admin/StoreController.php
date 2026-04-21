<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::query();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(code) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(store_category) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $search . '%']);
            });
        }

        $stores = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:stores,code',
            'store_category' => 'required|string|in:A,B,C',
            'address' => 'required|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $validatedData['is_active'] = $request->boolean('is_active');

        Store::create($validatedData);

        return redirect()->route('admin.stores.index')->with('message', 'Store created successfully.');
    }

    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:stores,code,' . $store->id,
            'store_category' => 'required|string|in:A,B,C',
            'address' => 'required|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $validatedData['is_active'] = $request->boolean('is_active');

        $store->update($validatedData);

        return redirect()->route('admin.stores.index')->with('message', 'Store updated successfully.');
    }

    public function destroy(Store $store)
    {
        $store->delete();

        return redirect()->back()->with('message', 'Store deleted successfully.');
    }
}
