<div class="animate-in fade-in duration-300 relative w-full pb-10">

    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-1.5 text-[13px] font-medium mb-2" aria-label="Breadcrumb">
        <span class="text-gray-400">Overview</span>
        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-600">Dashboard</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Ringkasan performa toko hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <div
                class="inline-flex items-center gap-2 bg-white border border-gray-200 rounded-lg px-3.5 py-2 text-[13px] font-medium text-gray-600 shadow-sm">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                {{ now()->translatedFormat('d M Y') }}
            </div>
        </div>
    </div>

    <!-- Due Date Information Banners -->
    @if(isset($upcomingDueInstallments) && $upcomingDueInstallments->count() > 0)
        <div class="mb-6 space-y-3">
            @foreach($upcomingDueInstallments as $installment)
                <div
                    class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200 shadow-sm animate-in fade-in slide-in-from-top-2 duration-300">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center border border-amber-200">
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
                    <div>
                        <a href="{{ route('admin.sales.show', $installment->id) }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-amber-700 bg-white border border-amber-300 rounded-lg hover:bg-amber-50 hover:text-amber-800 transition-colors shadow-sm whitespace-nowrap">
                            Lihat Detail
                        </a>
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
                        {{ number_format($todayRevenue, 0, ',', '.') }}
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
                <p class="text-xs font-medium text-gray-500 mb-1">Total Orders</p>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                        {{ number_format($todayOrders, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Metric 3: Produk Terjual -->
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

    <!-- Revenue Chart -->
    <div class="mb-6 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col" x-data="{
            activeTab: 'daily',
            chart: null,
            datasets: {
                daily: {
                    labels: @js($dailyChart->pluck('label')),
                    data: @js($dailyChart->pluck('value'))
                },
                monthly: {
                    labels: @js($monthlyChart->pluck('label')),
                    data: @js($monthlyChart->pluck('value'))
                },
                yearly: {
                    labels: @js($yearlyChart->pluck('label')),
                    data: @js($yearlyChart->pluck('value'))
                }
            },
            initChart() {
                if (typeof Chart === 'undefined') return;
                
                this.$nextTick(() => {
                    const ctx = this.$refs.revenueChart.getContext('2d');
                    
                    // Destroy existing chart if it exists
                    if (this.chart) {
                        this.chart.destroy();
                    }

                    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
                    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
                    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.01)');

                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: this.datasets[this.activeTab].labels,
                            datasets: [{
                                label: 'Revenue',
                                data: this.datasets[this.activeTab].data,
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: gradient,
                                borderWidth: 2.5,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: 'rgb(59, 130, 246)',
                                pointBorderWidth: 2,
                                pointHoverRadius: 6,
                                pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                                pointHoverBorderColor: '#fff',
                                pointHoverBorderWidth: 2.5,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#1f2937',
                                    padding: { x: 12, y: 8 },
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(ctx) {
                                            return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 10, weight: '500' }, color: '#9ca3af' },
                                    border: { display: false }
                                },
                                y: {
                                    grid: { color: '#f3f4f6', drawBorder: false },
                                    ticks: {
                                        font: { size: 10, weight: '500' },
                                        color: '#9ca3af',
                                        callback: function(value) {
                                            if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M';
                                            if (value >= 1000) return (value / 1000).toFixed(0) + 'K';
                                            return value;
                                        },
                                        maxTicksLimit: 5
                                    },
                                    border: { display: false }
                                }
                            },
                            interaction: { intersect: false, mode: 'index' }
                        }
                    });
                });
            },
            switchTab(tab) {
                this.activeTab = tab;
                if (this.chart) {
                    this.chart.data.labels = this.datasets[tab].labels;
                    this.chart.data.datasets[0].data = this.datasets[tab].data;
                    this.chart.update();
                }
            }
        }" x-init="initChart()">
        <!-- Chart Header -->
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Perkembangan Revenue</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Keuntungan berdasarkan periode</p>
            </div>
            <!-- Tab Switcher -->
            <div class="flex items-center bg-gray-100 rounded-lg p-0.5 gap-0.5">
                <button type="button" @click="switchTab('daily')" :class="activeTab === 'daily' ? 'bg-white text-gray-900 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1.5 text-[11px] font-semibold rounded-md transition-all">
                    Harian
                </button>
                <button type="button" @click="switchTab('monthly')" :class="activeTab === 'monthly' ? 'bg-white text-gray-900 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1.5 text-[11px] font-semibold rounded-md transition-all">
                    Bulanan
                </button>
                <button type="button" @click="switchTab('yearly')" :class="activeTab === 'yearly' ? 'bg-white text-gray-900 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1.5 text-[11px] font-semibold rounded-md transition-all">
                    Tahunan
                </button>
            </div>
        </div>
        <!-- Chart Canvas -->
        <div class="p-5 grow flex items-center">
            <div class="w-full" style="height: 280px;">
                <canvas x-ref="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Penjualan Terakhir -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Penjualan Terakhir</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">5 transaksi terbaru</p>
            </div>
            <a href="{{ route('admin.sales-history.index') }}" wire:navigate
                class="text-[12px] font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span>Invoice</span>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 min-w-[120px]">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                                <span>Kasir</span>
                            </div>
                        </th>
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span>Total</span>
                            </div>
                        </th>
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 text-center">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($recentSales as $sale)
                        <tr class="hover:bg-gray-50 cursor-default transition-colors">
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <span
                                    class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded text-[11px] font-mono tracking-tight font-semibold border border-gray-200/50">
                                    {{ $sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-3 py-2.5 border-r border-gray-200">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-6 w-6 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 text-[10px] font-bold shrink-0">
                                        {{ strtoupper(substr($sale->cashier ? $sale->cashier->name : 'S', 0, 1)) }}
                                    </div>
                                    <span class="text-[13px] font-semibold text-gray-900 truncate block max-w-[120px]">
                                        {{ $sale->cashier ? $sale->cashier->name : 'System' }}
                                    </span>
                                </div>
                            </td>
                            <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                <div class="flex items-center gap-1.5 font-mono">
                                    <span class="text-[10px] text-blue-400 font-sans">Rp</span>
                                    <span
                                        class="text-[13px] text-blue-700 font-bold">{{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="w-px whitespace-nowrap px-3 py-2.5 text-center">
                                @if ($sale->status === 'completed')
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm leading-none">Lunas</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-100 shadow-sm leading-none">Cicilan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-10 text-center">
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
    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
@endpush