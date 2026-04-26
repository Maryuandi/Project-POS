<div wire:key="product-detail-root" class="animate-in fade-in duration-300 relative w-full pb-10">

    <!-- Breadcrumbs Section -->
    <nav class="flex items-center space-x-1.5 text-sm font-medium mb-4" aria-label="Breadcrumb">
        <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-blue-600 transition-colors"
            wire:navigate>Products</a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-600 font-semibold">{{ $product->name }}</span>
    </nav>

    <!-- Product Header Card -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mb-6 p-6">
        <div class="flex flex-col gap-6">
            <div class="flex-1 flex flex-col justify-center mb-4">
                <div class="flex flex-wrap items-center gap-2 lg:gap-3 mb-3">
                    <span
                        class="text-xs font-mono font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100">SKU:
                        {{ $product->code }}</span>
                    @if($product->is_active)
                        <span
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-100 px-2.5 py-0.5 rounded-md border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Diarsipkan
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight leading-tight mb-2">
                    {{ $product->name }}
                </h1>

                @if($product->distributor)
                    <div class="mt-2.5 flex items-center gap-1.5 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span>Distributor: <span class="font-medium text-gray-700">{{ $product->distributor }}</span></span>
                    </div>
                @endif

                <!-- Quick Stats -->
                <div class="mt-6 grid grid-cols-2 gap-4 lg:gap-6 pt-6 border-t border-gray-100">
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Stok Saat Ini</p>
                        <div class="flex items-center gap-2">
                            <span
                                class="text-xl sm:text-2xl font-black tracking-tight {{ $product->stock > 10 ? 'text-blue-600' : ($product->stock > 0 ? 'text-amber-500' : 'text-red-600') }}">
                                {{ number_format($product->stock) }}
                            </span>
                            @if($product->stock === 0)
                                <span
                                    class="px-2 py-0.5 text-[10px] uppercase font-bold text-red-700 bg-red-100 rounded">Habis</span>
                            @elseif($product->stock <= 10)
                                <span
                                    class="px-2 py-0.5 text-[10px] uppercase font-bold text-amber-700 bg-amber-100 rounded">Menipis</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Harga Modal</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-800 tracking-tight">Rp
                            {{ number_format($product->cost, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section for History -->
    <div class="mb-4 mt-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-900 tracking-tight">Riwayat Pergerakan Stok</h2>
            <p class="text-sm text-gray-500 mt-0.5">Semua catatan barang masuk dan keluar untuk produk ini</p>
        </div>
    </div>

    <!-- Data Grid Table Section -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th scope="col"
                            class="px-4 py-3 text-xs font-medium text-gray-500 border-r border-gray-200 uppercase tracking-wider">
                            Tanggal & Waktu</th>
                        <th scope="col"
                            class="px-4 py-3 text-xs font-medium text-gray-500 border-r border-gray-200 uppercase tracking-wider">
                            Perubahan Stok</th>
                        <th scope="col"
                            class="px-4 py-3 text-xs font-medium text-gray-500 border-r border-gray-200 uppercase tracking-wider">
                            Jenis Transaksi</th>
                        <th scope="col"
                            class="px-4 py-3 text-xs font-medium text-gray-500 border-r border-gray-200 uppercase tracking-wider">
                            Catatan</th>
                        <th scope="col"
                            class="px-4 py-3 text-xs font-medium text-gray-500 border-r border-gray-200 uppercase tracking-wider">
                            Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($stockMovements as $movement)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-4 py-3 border-r border-gray-200 whitespace-nowrap">
                                <span
                                    class="text-[13px] font-medium text-gray-900 block">{{ \Carbon\Carbon::parse($movement->occurred_at)->translatedFormat('d F Y') }}</span>
                                <span
                                    class="text-[11px] text-gray-500">{{ \Carbon\Carbon::parse($movement->occurred_at)->format('H:i') }}</span>
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200 whitespace-nowrap">
                                @if($movement->type === 'IN')
                                    <span
                                        class="inline-flex items-center gap-1 text-[13px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        +{{ $movement->qty_change }}
                                    </span>
                                @elseif($movement->type === 'OUT')
                                    <span
                                        class="inline-flex items-center gap-1 text-[13px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                        -{{ $movement->qty_change }}
                                    </span>
                                @else
                                    <span class="text-[13px] font-medium text-gray-500">{{ $movement->qty_change }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200 whitespace-nowrap">
                                <span
                                    class="capitalize text-[12px] font-medium {{ $movement->type === 'IN' ? 'text-emerald-700' : ($movement->type === 'OUT' ? 'text-amber-700' : 'text-blue-700') }}">
                                    {{ $movement->reference_type ?? $movement->type }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200">
                                <span class="text-xs text-gray-600 max-w-lg block truncate"
                                    title="{{ $movement->reason }}">{{ $movement->reason ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="text-[12px] font-medium text-gray-800">{{ $movement->createdBy->name ?? 'System' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat stok</h3>
                                <p class="mt-1 text-xs text-gray-500">Pergerakan produk (masuk/keluar) akan tercatat
                                    otomatis di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($stockMovements->hasPages())
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
                {{ $stockMovements->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>
