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
                <div class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200 shadow-sm animate-in fade-in slide-in-from-top-2 duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center border border-amber-200">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-amber-900 tracking-tight">Pengingat Jatuh Tempo!</h4>
                        <p class="text-[13px] text-amber-800 mt-0.5">
                            Transaksi <span class="font-semibold">{{ $installment->invoice_no }}</span> 
                            akan jatuh tempo pada 
                            <span class="font-bold underline decoration-amber-300">{{ \Carbon\Carbon::parse($installment->due_date)->translatedFormat('d F Y') }}</span>.
                            Sisa tagihan: <span class="font-semibold">Rp {{ number_format($installment->amount_due, 0, ',', '.') }}</span>.
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('admin.sales.show', $installment->id) }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-amber-700 bg-white border border-amber-300 rounded-lg hover:bg-amber-50 hover:text-amber-800 transition-colors shadow-sm whitespace-nowrap">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


</div>