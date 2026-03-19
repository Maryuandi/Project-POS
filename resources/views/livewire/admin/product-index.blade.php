<div wire:key="product-index-root" class="animate-in fade-in duration-300 relative w-full pb-10">

    <!-- Breadcrumbs Section -->
    <nav class="flex items-center space-x-1.5 text-sm font-medium mb-4" aria-label="Breadcrumb">
        <span class="text-gray-400">Products</span>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </nav>
    
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Products</h1>
            <p class="text-sm text-gray-500 mt-1">Manage inventory items, stock, and variations</p>
        </div>
        
        <a href="{{ route('admin.products.create') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add product
        </a>
    </div>

    <!-- Tabs Section -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="{{ request()->fullUrlWithQuery(['filterStatus' => 'all', 'page' => null]) }}" wire:navigate class="{{ $filterStatus === 'all' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-blue-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                Semua Produk <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs">{{ \App\Models\Product::count() }}</span>
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filterStatus' => 'available', 'page' => null]) }}" wire:navigate class="{{ $filterStatus === 'available' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-blue-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                Available <span class="ml-2 bg-emerald-50 text-emerald-600 py-0.5 px-2.5 rounded-full text-xs font-bold">{{ \App\Models\Product::where('stock', '>', 10)->count() }}</span>
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filterStatus' => 'low_stock', 'page' => null]) }}" wire:navigate class="{{ $filterStatus === 'low_stock' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-blue-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                Low Stock <span class="ml-2 bg-amber-50 text-amber-600 py-0.5 px-2.5 rounded-full text-xs font-bold">{{ \App\Models\Product::whereBetween('stock', [1, 10])->count() }}</span>
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filterStatus' => 'out_of_stock', 'page' => null]) }}" wire:navigate class="{{ $filterStatus === 'out_of_stock' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-blue-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                Habis <span class="ml-2 bg-red-50 text-red-600 py-0.5 px-2.5 rounded-full text-xs font-bold">{{ \App\Models\Product::where('stock', 0)->count() }}</span>
            </a>
        </nav>
    </div>



    <!-- Toolbar Section (Traditional GET Filtering for Speed) -->
    <form method="GET" action="{{ url()->current() }}" class="mb-4 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4">
        
        <!-- Hidden input for Status to persist tab state -->
        <input type="hidden" name="filterStatus" value="{{ $filterStatus }}">

        <!-- Left: Search input -->
        <div class="relative w-full xl:w-[320px]">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" name="search" value="{{ $search }}"
                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" 
                placeholder="Cari Produk...">
        </div>
        
        <!-- Right: Filters dropdowns -->
        <div class="flex flex-wrap items-center gap-2 w-full xl:w-auto">
            <!-- Filter Category -->
            <div class="relative min-w-[140px]">
                <select name="filterCategory" onchange="this.form.submit()" 
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm pr-8">
                    <option value="">All Categories</option>
                    @foreach($categoriesList as $cat)
                        <option value="{{ $cat->id }}" {{ $filterCategory == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
                </div>
            </div>

            <!-- Reset Button (Enhanced) -->
            <a href="{{ request()->url() }}?filterStatus={{ $filterStatus }}" 
                class="inline-flex items-center gap-2 px-3 py-2 border border-gray-200 bg-white rounded-lg text-gray-500 hover:text-red-600 hover:border-red-100 hover:bg-red-50 transition-all shadow-sm text-[13px] font-medium shrink-0" title="Clear Filters">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span>Clear</span>
            </a>
        </div>
    </form>

    <!-- Data Grid Table Section -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mt-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th scope="col" class="w-10 px-3 py-2 text-center border-r border-gray-200">
                            <input type="checkbox" class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </th>
                        
                        <!-- Nama Mainan (With Small Image) -->
                        <th scope="col" class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 sm:w-auto min-w-[140px]">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <span>Produk</span>
                            </div>
                        </th>
                        
                        <!-- Category -->
                        <th scope="col" class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                <span>Category</span>
                            </div>
                        </th>
                        
                        <!-- Status -->
                        <th scope="col" class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Status</span>
                            </div>
                        </th>

                        <!-- Jumlah Stok -->
                        <th scope="col" class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <span>Stok</span>
                            </div>
                        </th>

                        <!-- Harga Beli -->
                        <th scope="col" class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Harga Beli</span>
                            </div>
                        </th>

                        <!-- Harga Jual -->
                        <th scope="col" class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>Harga Jual</span>
                            </div>
                        </th>
                        
                        <!-- Distributor -->
                        <th scope="col" class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span>Distributor</span>
                            </div>
                        </th>
                        
                        <!-- Actions -->
                        <th scope="col" class="px-3 py-2 text-center w-12 text-gray-400">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($products as $product)
                        <tr wire:key="product-row-{{ $product->id }}" class="hover:bg-gray-50 cursor-default transition-colors group">
                            
                            <!-- Checkbox -->
                            <td class="px-3 py-2.5 text-center border-r border-gray-200">
                                <input type="checkbox" class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            </td>

                            <!-- Nama Mainan & Gambar Minor -->
                            <td class="px-3 py-2.5 border-r border-gray-200">
                                <div class="flex items-center gap-3">
                                    @if($product->image_path)
                                        <img src="{{ Str::startsWith($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-8 h-8 rounded-md object-cover border border-gray-100 shadow-sm shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-md bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-400 text-[10px] font-bold shrink-0">
                                            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <span class="text-[13px] font-semibold text-gray-900 truncate block max-w-[180px]">{{ $product->name }}</span>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <span class="inline-flex items-center px-2 py-1 rounded text-[11px] font-medium bg-gray-100 text-gray-700 border border-gray-200/50 shadow-sm leading-none">
                                    {{ $product->category->name ?? '-' }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                @php
                                    $totalStock = $product->stock ?? 0;
                                    $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                    $statusLabel = 'Available';
                                    
                                    if ($totalStock == 0) {
                                        $statusClass = 'bg-red-50 text-red-700 border-red-100';
                                        $statusLabel = 'Out of Stock';
                                    } elseif ($totalStock <= 10) {
                                        $statusClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                        $statusLabel = 'Low Stock';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold border {{ $statusClass }} shadow-sm leading-none">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <!-- Jumlah Stok -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 font-mono text-[13px] {{ ($product->stock ?? 0) <= 10 ? 'text-red-600 font-bold' : 'text-gray-900 font-medium' }}">
                                {{ number_format($product->stock ?? 0) }} Pcs
                            </td>

                            <!-- Harga Beli -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <div class="flex items-center gap-1.5 font-mono">
                                    <span class="text-[10px] text-gray-400 font-sans">Rp</span>
                                    <span class="text-[13px] text-gray-700 font-medium">{{ number_format($product->cost ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </td>

                            <!-- Harga Jual -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <div class="flex items-center gap-1.5 font-mono">
                                    <span class="text-[10px] text-blue-400 font-sans">Rp</span>
                                    <span class="text-[13px] text-blue-700 font-bold">{{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </td>

                            <!-- Distributor -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <span class="text-[13px] text-gray-600 font-medium truncate inline-block max-w-[120px]">{{ $product->distributor ?? '-' }}</span>
                            </td>

                            <!-- Actions -->
                            <td class="px-3 py-2.5 text-right w-20 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" wire:navigate title="Edit"
                                        class="inline-flex items-center justify-center w-7 h-7 bg-white border border-gray-200 rounded-lg shadow-sm text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all focus:outline-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <button type="button" 
                                        @click="$dispatch('open-delete-modal', { name: '{{ addslashes($product->name) }}', url: '{{ route('admin.products.destroy', $product->id) }}' })"
                                        title="Delete" 
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white border border-gray-200 rounded-lg shadow-sm text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all focus:outline-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-3 py-10 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                                <p class="mt-1 text-xs text-gray-500">The grid is currently empty.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Wrapper -->
        @if ($products->hasPages())
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
                {{ $products->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>

    <!-- Alpine.js Delete Confirmation Modal -->
    <div x-data="{ open: false, productName: '', deleteUrl: '' }" 
         x-on:open-delete-modal.window="open = true; productName = $event.detail.name; deleteUrl = $event.detail.url"
         x-show="open" 
         class="fixed inset-0 z-[99998] overflow-y-auto" 
         style="display: none;">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="open = false" x-show="open" x-transition:outline></div>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">
                <div class="bg-white px-5 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Hapus Produk</h3>
                            <div class="mt-2">
                                <p class="text-[14px] text-gray-500 font-medium">
                                    Apakah Anda yakin ingin menghapus produk <strong x-text="productName" class="text-gray-900"></strong>? Data ini akan dihapus permanen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto transition-all">
                            Hapus Sekarang
                        </button>
                    </form>
                    <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Native Browser Alert for Success Message -->
    @if (session()->has('message'))
        <div x-data x-init="alert('{{ session('message') }}')"></div>
    @endif
</div>
