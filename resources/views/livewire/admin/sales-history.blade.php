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

        <div class="flex items-center gap-3">
            <button type="button"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export Data
            </button>

            <!-- Notification Bell (Unpaid Installments) -->
            <button type="button" @click="$dispatch('open-reminder-modal')"
                class="flex items-center justify-center w-10 h-10 border border-amber-200 bg-amber-50 rounded-lg text-amber-700 hover:text-amber-800 hover:border-amber-300 hover:bg-amber-100 transition-all shadow-sm relative shrink-0"
                title="Pengingat Cicilan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span class="sr-only">Pengingat Cicilan</span>
                @if (isset($unpaidInstallments) && count($unpaidInstallments) > 0)
                    <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-red-500 border-2 border-white"></span>
                    </span>
                @endif
            </button>
        </div>
    </div>

    <!-- Due Date Information Banners -->
    @if(isset($upcomingDueInstallments) && $upcomingDueInstallments->count() > 0)
        <div class="mb-6 space-y-3">
            @foreach($upcomingDueInstallments as $installment)
                <div x-data="{ show: true }" x-show="show"
                    class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200 shadow-sm transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-amber-200">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-amber-900 tracking-tight">Pengingat Jatuh Tempo!</h4>
                        <p class="text-[13px] text-amber-800 mt-0.5">
                            Transaksi <span class="font-semibold">{{ $installment->invoice_no }}</span>
                            akan jatuh tempo pada
                            <span
                                class="font-bold underline decoration-amber-300">{{ \Carbon\Carbon::parse($installment->due_date)->translatedFormat('d F Y') }}</span>.
                            Sisa tagihan: <span class="font-semibold">Rp
                                {{ number_format($installment->amount_due, 0, ',', '.') }}</span>.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.sales.show', $installment->id) }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-amber-700 bg-white border border-amber-300 rounded-lg hover:bg-amber-50 hover:text-amber-800 transition-colors shadow-sm whitespace-nowrap">
                            Lihat Detail
                        </a>
                        <button type="button" @click="show = false"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-500 hover:bg-amber-100/50 hover:text-amber-800 transition-colors outline-none focus:ring-2 focus:ring-amber-500/20"
                            aria-label="Tutup Pengingat" title="Tutup">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

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
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Rp
                        {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
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
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                        {{ number_format($totalTransactions, 0, ',', '.') }}
                    </h3>

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
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                        {{ number_format($totalProductsSold, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search Section -->
    <form method="GET" action="{{ url()->current() }}"
        class="mb-4 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4 mt-4">

        <!-- Left: Search input -->
        <div class="relative w-full xl:w-[320px]">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ $search }}"
                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                placeholder="Cari invoice, kasir, atau store...">
        </div>

        <!-- Right: Filters dropdowns -->
        <!-- Right: Filters dropdowns -->
        <div x-data="{
            dateType: '{{ $filterDate ?? 'semua' }}',
            previousDateType: '{{ $filterDate ?? 'semua' }}',
            showCustomModal: false
        }" class="flex flex-wrap items-center gap-2 w-full xl:w-auto">

            <!-- Filter Date Type -->
            <div class="relative min-w-[140px]">
                <select name="filterDate" x-model="dateType"
                    @change="if($event.target.value === 'custom') { showCustomModal = true; } else { $event.target.form.submit(); }"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm pr-8">
                    <option value="semua">Semua Waktu</option>
                    <option value="harian">Harian (Hari Ini)</option>
                    <option value="mingguan">Mingguan (7 Hari)</option>
                    <option value="bulanan">Bulanan (Bulan Ini)</option>
                    <option value="custom">Pilih Rentang Waktu</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    </svg>
                </div>
            </div>

            <!-- Custom Date Modal -->
            <div x-show="showCustomModal" style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4 sm:p-0">
                <!-- Modal Backdrop -->
                <div x-show="showCustomModal" x-transition.opacity class="fixed inset-0"
                    @click="showCustomModal = false; dateType = previousDateType"></div>

                <!-- Modal Panel -->
                <div x-show="showCustomModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    style="max-width: 320px;"
                    class="relative w-full transform overflow-hidden rounded-xl bg-white text-left align-middle shadow-2xl transition-all mx-4">

                    <div class="border-b border-gray-100 px-4 py-3 flex items-center justify-between bg-gray-50/80">
                        <h3 class="text-[15px] font-bold text-gray-900 tracking-tight">Pilih Rentang Waktu</h3>
                        <button type="button" @click="showCustomModal = false; dateType = previousDateType"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors rounded-lg hover:bg-gray-200/50 p-1">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 space-y-3.5">
                        <div class="mb-4">
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Dari</label>
                            <input type="date" name="startDate" value="{{ $startDate }}"
                                class="block w-full px-3 py-1.5 border border-gray-300 rounded-lg text-[13px] bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors shadow-sm">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Sampai</label>
                            <input type="date" name="endDate" value="{{ $endDate }}"
                                class="block w-full px-3 py-1.5 border border-gray-300 rounded-lg text-[13px] bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors shadow-sm">
                        </div>
                    </div>

                    <div class="border-t border-gray-100 px-4 py-3 bg-gray-50/80 flex justify-end gap-2">
                        <button type="button" @click="showCustomModal = false; dateType = previousDateType"
                            class="px-3 py-1.5 text-[13px] font-semibold text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                            Batal
                        </button>
                        <button type="button" @click="$event.target.closest('form').submit()"
                            class="px-3 py-1.5 text-[13px] font-semibold text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all shadow-sm">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filter Status -->
            <div class="relative min-w-[140px]">
                <select name="filterStatus" onchange="this.form.submit()"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm pr-8">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ $filterStatus === 'completed' ? 'selected' : '' }}>Lunas</option>
                    <option value="installment" {{ $filterStatus === 'installment' ? 'selected' : '' }}>Cicilan</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    </svg>
                </div>
            </div>

            <!-- Reset Button (Enhanced) -->
            <a href="{{ request()->url() }}"
                class="inline-flex items-center gap-2 px-3 py-2 border border-gray-200 bg-white rounded-lg text-gray-500 hover:text-red-600 hover:border-red-100 hover:bg-red-50 transition-all shadow-sm text-[13px] font-medium shrink-0"
                title="Clear Filters">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>Clear</span>
            </a>
        </div>
    </form>

    <!-- Data Table Section -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
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

                        <!-- Store -->
                        <th scope="col"
                            class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 sm:w-auto min-w-[140px]">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M9 7V5a3 3 0 016 0v2"></path>
                                </svg>
                                <span>Store</span>
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
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status</span>
                            </div>
                        </th>

                        <!-- Due Date -->
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 text-center">
                            <div class="flex items-center justify-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Jatuh Tempo</span>
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

                            <!-- Store -->
                            <td class="px-3 py-2.5 border-r border-gray-200">
                                <div class="flex flex-col">
                                    <span class="text-[13px] font-semibold text-gray-900 truncate block max-w-[180px]">
                                        {{ $sale->store->name ?? '-' }}
                                    </span>
                                    @if($sale->store)
                                        <span class="text-[11px] text-gray-500">{{ $sale->store->code }} · {{ $sale->store->store_category }}</span>
                                    @endif
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
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm leading-none">Lunas</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-100 shadow-sm leading-none">Cicilan</span>
                                @endif
                            </td>

                            <!-- Due Date -->
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 text-center">
                                @if($sale->due_date)
                                    <span
                                        class="text-[12px] text-gray-600 font-medium">{{ \Carbon\Carbon::parse($sale->due_date)->translatedFormat('d M Y') }}</span>
                                @else
                                    <span class="text-gray-400 text-[12px]">&mdash;</span>
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
                            <td colspan="10" class="px-3 py-10 text-center">
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
                {{ $sales->links('livewire.admin.pagination', ['scrollTo' => false]) }}
            </div>
        @endif
    </div>

    <!-- Alpine.js Reminder Modal -->
    <div x-data="{ open: false }" x-on:open-reminder-modal.window="open = true" x-show="open"
        class="fixed inset-0 z-[99998] overflow-y-auto" style="display: none;">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="open = false"
                x-show="open" x-transition:outline></div>

            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-100 flex flex-col max-h-[85vh]">

                <!-- Modal Header -->
                <div
                    class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80 shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Pengingat Tagihan Cicilan</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Transaksi yang belum lunas hari ini.</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="text-gray-400 hover:text-gray-500 p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="p-0 overflow-y-auto grow">
                    @if (isset($unpaidInstallments) && count($unpaidInstallments) > 0)
                        <ul class="divide-y divide-gray-100">
                            @foreach ($unpaidInstallments as $installment)
                                <li class="p-5 hover:bg-gray-50/50 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span
                                                    class="text-[14px] font-bold text-gray-900">{{ $installment->invoice_no ?? '#' . str_pad($installment->id, 6, '0', STR_PAD_LEFT) }}</span>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700">Belum
                                                    Lunas</span>
                                            </div>
                                            <p class="text-[13px] text-gray-500 mb-2">Kasir: <span
                                                    class="font-medium text-gray-700">{{ $installment->cashier->name ?? 'System' }}</span>
                                                •
                                                {{ $installment->sold_at ? $installment->sold_at->format('d M Y, H:i') : $installment->created_at->format('d M Y, H:i') }}
                                            </p>

                                            <div class="flex items-center gap-4 text-[13px]">
                                                <div>
                                                    <span class="text-gray-400">Terbayar:</span>
                                                    <span class="font-bold text-emerald-600">Rp
                                                        {{ number_format($installment->amount_paid, 0, ',', '.') }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-400">Sisa Tagihan:</span>
                                                    <span class="font-bold text-red-600">Rp
                                                        {{ number_format($installment->amount_due, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.sales.show', $installment->id) }}" wire:navigate
                                            class="shrink-0 inline-flex items-center justify-center px-4 py-2 text-[13px] font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                            Update Cicilan
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="py-12 px-6 text-center">
                            <div
                                class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-[15px] font-bold text-gray-900 mb-1">Semua Tagihan Lunas!</h4>
                            <p class="text-[13px] text-gray-500">Tidak ada transaksi cicilan yang perlu diperhatikan saat
                                ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
