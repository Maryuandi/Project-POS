<div wire:key="sales-history-root" class="animate-in fade-in duration-300 relative w-full pb-10">

    <!-- Breadcrumbs Section -->
    <nav class="flex items-center space-x-1.5 text-sm font-medium mb-4" aria-label="Breadcrumb">
        <span class="text-gray-400">Sales History</span>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </nav>

    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Sales History</h1>
            <p class="text-sm text-gray-500 mt-1">View completed transactions and sales records</p>
        </div>

        <button type="button"
            class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Export Data
        </button>
    </div>

    <!-- Metrics Section -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <!-- Metric 1: Total Revenue -->
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center bg-white mb-4">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Total Revenue</p>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Metric 2: Total Transactions -->
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center bg-white mb-4">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Total Transactions</p>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">{{ number_format($totalTransactions, 0, ',', '.') }}</h3>

                </div>
            </div>
        </div>

        <!-- Metric 3: Average Transaction -->
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center bg-white mb-4">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Produk Terjual</p>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">{{ number_format($totalProductsSold, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mt-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th scope="col" class="w-10 px-3 py-2 text-center border-r border-gray-200">
                            <input type="checkbox"
                                class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </th>

                        <!-- Invoice No -->
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span>Invoice No</span>
                            </div>
                        </th>

                        <!-- Date -->
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Date</span>
                            </div>
                        </th>

                        <!-- Cashier -->
                        <th scope="col"
                            class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 sm:w-auto min-w-[140px]">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Kasir</span>
                            </div>
                        </th>

                        <!-- Total -->
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span>Total Belanja</span>
                            </div>
                        </th>

                        <!-- Payment -->
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 text-center">
                            <div class="flex items-center justify-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                <span>Pembayaran</span>
                            </div>
                        </th>

                        <!-- Status -->
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 text-center">
                            <div class="flex items-center justify-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status</span>
                            </div>
                        </th>

                        <!-- Actions -->
                        <th scope="col" class="px-3 py-2 text-center w-20 text-gray-400">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                </path>
                            </svg>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($sales as $sale)
                        <tr wire:key="sale-row-{{ $sale->id }}"
                            class="hover:bg-gray-50 cursor-default transition-colors group">

                            <!-- Checkbox -->
                            <td class="px-3 py-2.5 text-center border-r border-gray-200">
                                <input type="checkbox"
                                    class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            </td>

                            <!-- Invoice No -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <span
                                    class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded text-[11px] font-mono tracking-tight font-semibold border border-gray-200/50">
                                    {{ $sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <!-- Date -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <span class="text-[13px] text-gray-600 font-medium">
                                    {{ $sale->sold_at ? $sale->sold_at->format('d M Y, H:i') : $sale->created_at->format('d M Y, H:i') }}
                                </span>
                            </td>

                            <!-- Cashier -->
                            <td class="px-3 py-2.5 border-r border-gray-200">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-6 w-6 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 text-[10px] font-bold shrink-0">
                                        {{ strtoupper(substr($sale->cashier ? $sale->cashier->name : 'S', 0, 1)) }}
                                    </div>
                                    <span class="text-[13px] font-semibold text-gray-900 truncate block max-w-[180px]">
                                        {{ $sale->cashier ? $sale->cashier->name : 'System' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Total -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <div class="flex items-center gap-1.5 font-mono">
                                    <span class="text-[10px] text-blue-400 font-sans">Rp</span>
                                    <span
                                        class="text-[13px] text-blue-700 font-bold">{{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </td>

                            <!-- Payment -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 text-center">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm leading-none">
                                    {{ ucfirst($sale->payment_method ?? 'Cash') }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 text-center">
                                @if($sale->status === 'completed')
                                    <span class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm leading-none">Lunas</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-100 shadow-sm leading-none">Cicilan</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-3 py-2.5 text-center w-24 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.sales.show', $sale->id) }}" wire:navigate title="View Detail"
                                        class="inline-flex items-center justify-center w-7 h-7 bg-white border border-gray-200 rounded-lg shadow-sm text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all focus:outline-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-3 py-10 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada transaksi</h3>
                                <p class="mt-1 text-xs text-gray-500">History penjualan masih kosong.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Wrapper -->
        @if ($sales->hasPages())
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
                {{ $sales->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>