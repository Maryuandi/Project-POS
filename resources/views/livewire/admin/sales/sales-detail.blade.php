<div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="whatsappReceipt()">

    {{-- Header Actions --}}
    <div class="mb-4 flex justify-between items-center no-print print:hidden">
        <a href="{{ route('admin.sales-history.index') }}" wire:navigate
            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to Sales
        </a>
        <div class="flex items-center gap-4">
            {{-- WhatsApp Button --}}
            <button @click="showModal = true" type="button"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white rounded-lg shadow-sm hover:opacity-90 transition-all"
                style="background-color: #16a34a; border: 1px solid #16a34a;">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                Kirim ke WA
            </button>
            {{-- Print Button --}}
            <button onclick="window.print()" type="button"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-all">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Print / Save PDF
            </button>
        </div>
    </div>

    {{-- WhatsApp Modal --}}
    <div x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 no-print" style="display: none;">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showModal = false"></div>
        {{-- Modal Content --}}
        <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-xl shadow-2xl w-full max-w-md p-6 z-10">
            {{-- Close --}}
            <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            </button>
            {{-- Header --}}
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Kirim Struk ke WhatsApp</h3>
                    <p class="text-sm text-gray-500">Masukkan nomor HP customer</p>
                </div>
            </div>
            {{-- Input --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor WhatsApp</label>
                <div class="relative">
                    <input type="tel" x-model="phoneNumber" @keydown.enter="sendWhatsApp()" placeholder="812345678xx"
                        class="w-full pl-12 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all"
                        autofocus>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">Contoh: 81234567890 (tanpa 0 di depan)</p>
            </div>
            {{-- Preview (collapsed by default) --}}
            <details class="mb-5">
                <summary class="text-xs font-medium text-gray-500 cursor-pointer hover:text-gray-700 select-none">Lihat
                    preview pesan</summary>
                <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-100 max-h-48 overflow-y-auto">
                    <pre class="text-xs text-gray-700 whitespace-pre-wrap font-sans leading-relaxed"
                        x-text="receiptText"></pre>
                </div>
            </details>
            {{-- Actions --}}
            <div class="flex gap-3">
                <button @click="showModal = false"
                    class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button @click="sendWhatsApp()"
                    class="flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-lg hover:opacity-90 transition-colors inline-flex items-center justify-center gap-2"
                    style="background-color: #16a34a;">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Kirim
                </button>
            </div>
        </div>
    </div>

    {{-- Invoice Card --}}
    <div
        class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden print:shadow-none print:border-none print:rounded-none">
        <div class="p-6 sm:p-8">

            {{-- Company Header --}}
            <div class="flex justify-between items-start pb-8 mb-3 border-b border-gray-100">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">Toko Mainan ABCD</h2>
                    <p class="text-xs text-gray-500 mt-2">Jl. Jendral Sudirman No. 123<br>Puwokerto, Indonesia 12345</p>
                    <p class="text-xs text-gray-500 mt-2">No Telp : 08123456789</p>
                </div>
                <div class="text-right">
                    <h1 class="text-2xl font-light text-gray-400 tracking-widest uppercase mb-1.5">Nota Pembelian</h1>
                    @if($sale->status === 'completed')
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Lunas</span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Cicilan</span>
                    @endif
                </div>
            </div>

            {{-- Transaction Meta --}}
            <div class="grid grid-cols-2 gap-y-8 gap-x-12 pb-8 mb-6 mt-8 border-b border-gray-100">
                <div class="mb-3">
                    <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Invoice No.</h5>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
                <div>
                    <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Date & Time</h5>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $sale->sold_at ? $sale->sold_at->format('M d, Y H:i') : $sale->created_at->format('M d, Y H:i') }}
                    </p>
                </div>
                <div>
                    <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Cashier</h5>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $sale->cashier ? $sale->cashier->name : 'System' }}
                    </p>
                </div>
                <div>
                    <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Payment Method</h5>
                    <p class="text-sm font-semibold text-gray-900 capitalize">{{ $sale->payment_method ?? 'Cash' }}</p>
                </div>
                <div>
                    <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Store</h5>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $sale->store?->name ?? '-' }}
                    </p>
                </div>
                <div>
                    <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Store Info</h5>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $sale->store?->code ?? '-' }}{{ $sale->store ? ' · ' . $sale->store->store_category : '' }}
                    </p>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="mb-6 mt-6 border border-gray-200 rounded-lg overflow-hidden print:border-gray-300">
                <table class="w-full text-left divide-y divide-gray-200 print:divide-gray-300">
                    <thead class="bg-gray-50 print:bg-transparent">
                        <tr>
                            <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider">Item
                            </th>
                            <th
                                class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-right">
                                Price</th>
                            <th
                                class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-center">
                                Qty</th>
                            <th
                                class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-right">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white print:divide-gray-300">
                        @forelse ($sale->saleItems as $item)
                            <tr>
                                <td class="px-3 py-3">
                                    <div class="text-[13px] font-medium text-gray-900">
                                        {{ $item->product->name ?? 'Unknown Product' }}
                                    </div>
                                    <div class="text-[11px] text-gray-400">SKU: {{ $item->product->code ?? '-' }}</div>
                                </td>
                                <td class="px-3 py-3 text-[13px] text-gray-500 text-right whitespace-nowrap">Rp
                                    {{ number_format($item->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-3 text-[13px] text-gray-900 text-center font-medium">{{ $item->qty }}
                                </td>
                                <td class="px-3 py-3 text-[13px] text-gray-900 text-right font-medium whitespace-nowrap">Rp
                                    {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-6 text-center text-sm text-gray-500 italic">No items found
                                    for this transaction.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Summary --}}
            <div class="flex justify-end mb-6">
                <div class="w-full sm:w-2/3 md:w-1/2">
                    <div class="space-y-1.5">
                        <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">Rp
                                {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[13px] text-gray-500">
                            <span>Tax (0%)</span>
                            <span class="font-medium text-gray-900">Rp 0</span>
                        </div>
                    </div>
                    <div class="mt-3 m-3 pt-1.5 border-t border-gray-200">
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-sm font-semibold text-gray-900">Grand Total</span>
                            <span class="text-md font-bold text-gray-900 tracking-tight">Rp
                                {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @if (isset($sale->amount_received) && $sale->amount_received > 0)
                        <div class="mt-1.5 pt-1.5 border-t border-dashed border-gray-200 space-y-1">
                            <div class="flex justify-between text-[12px] text-gray-500">
                                <span>Amount Received</span>
                                <span>Rp {{ number_format($sale->amount_received, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-[12px] text-gray-500">
                                <span>Change Due</span>
                                <span>Rp
                                    {{ number_format($sale->amount_received - $sale->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-3 pt-3 border-t border-gray-100 text-center print:pt-3">
                <p class="text-[13px] font-medium text-gray-600 mt-3">Terima kasih atas pembelian Anda!</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Jika Anda memiliki pertanyaan tentang struk ini, silakan
                    hubungi 08123456789</p>
            </div>

        </div>
    </div>

    {{-- Installment Section (only shown if installment) --}}
    @if($sale->status === 'installment')
        <div x-data="{
                            showPayModal: false,
                            selectedMethod: '{{ $installMethod }}',
                            payAmount: {{ $sale->amount_due }},
                            isSubmitting: false,
                            async submitPayment() {
                                if (this.isSubmitting) return;
                                this.isSubmitting = true;
                                try {
                                    const res = await fetch('{{ route('admin.sales.pay-installment', $sale->id) }}', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                        body: JSON.stringify({ amount: this.payAmount, payment_method: this.selectedMethod })
                                    });
                                    const data = await res.json();
                                    if (res.ok) { window.location.reload(); }
                                    else { alert(data.message || 'Gagal'); this.isSubmitting = false; }
                                } catch (e) { alert('Koneksi gagal'); this.isSubmitting = false; }
                            }
                        }">
            <div class="mt-4 bg-white rounded-xl border border-amber-200 shadow-sm overflow-hidden no-print">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <h3 class="text-sm font-bold text-gray-900">Status Cicilan</h3>
                        </div>
                        <button @click="showPayModal = true"
                            class="inline-flex items-center px-3 py-1.5 text-[13px] font-semibold text-white bg-blue-500 hover:bg-amber-600 rounded-lg shadow-sm transition-all gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Bayar Cicilan
                        </button>
                    </div>

                    {{-- Progress Bar --}}
                    @php $paidPercent = $sale->total_amount > 0 ? round(($sale->amount_paid / $sale->total_amount) * 100) : 0; @endphp
                    <div class="mb-3">
                        <div class="flex justify-between text-[12px] mb-1.5">
                            <span class="font-medium text-gray-500">Terbayar: Rp
                                {{ number_format($sale->amount_paid, 0, ',', '.') }}</span>
                            <span class="font-bold text-amber-700">Sisa: Rp
                                {{ number_format($sale->amount_due, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500"
                                style="width: {{ $paidPercent }}%"></div>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1">{{ $paidPercent }}% dari total Rp
                            {{ number_format($sale->total_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Payment History --}}
            @if($sale->installmentPayments && $sale->installmentPayments->count() > 0)
                <div class="mt-4 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden no-print">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-900">Riwayat Pembayaran</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Metode</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($sale->installmentPayments->sortBy('paid_at') as $index => $payment)
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="px-4 py-2.5 text-[13px] text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2.5 text-[13px] text-gray-600 font-medium">
                                            {{ $payment->paid_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-4 py-2.5 text-[13px] font-bold text-emerald-700">Rp
                                            {{ number_format($payment->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600 border border-gray-200">{{ strtoupper($payment->payment_method) }}</span>
                                        </td>
                                        <td class="px-4 py-2.5 text-[12px] text-gray-400">{{ $payment->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Pay Installment Modal --}}
            <div x-show="showPayModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4 no-print"
                style="display: none;">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showPayModal = false"></div>
                <div x-show="showPayModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white rounded-xl shadow-2xl w-full max-w-md p-6 z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Bayar Cicilan</h3>
                            <p class="text-sm text-gray-500">Sisa tagihan: <span class="font-bold text-amber-700">Rp
                                    {{ number_format($sale->amount_due, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-5">
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2">Metode Pembayaran</label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach(['cash', 'qris', 'transfer'] as $method)
                                    <button type="button"
                                        @click="selectedMethod = '{{ $method }}'; $wire.set('installMethod', '{{ $method }}')"
                                        :class="selectedMethod === '{{ $method }}' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-200 text-gray-600'"
                                        class="rounded-lg border px-3 py-2 text-center text-[13px] font-medium transition-all">{{ strtoupper($method) }}</button>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2">Jumlah Bayar (Rp)</label>
                            <input type="number" x-model.number="payAmount"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-lg font-bold placeholder-gray-400 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all"
                                placeholder="0" max="{{ $sale->amount_due }}">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button @click="showPayModal = false"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                        <button @click="submitPayment()"
                            :disabled="isSubmitting || payAmount <= 0 || payAmount > {{ $sale->amount_due }}"
                            :class="isSubmitting ? 'bg-gray-400' : 'bg-amber-500 hover:bg-amber-600'"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-lg bg-blue-500 transition-colors inline-flex items-center justify-center gap-2">
                            <svg x-show="isSubmitting" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="isSubmitting ? 'Processing...' : 'Konfirmasi Bayar'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @php
        $itemsText = '';
        foreach ($sale->saleItems as $item) {
            $name = $item->product->name ?? 'Unknown';
            $qty = $item->qty;
            $price = number_format($item->unit_price, 0, ',', '.');
            $subtotal = number_format($item->subtotal, 0, ',', '.');
            $itemsText .= "• {$name} x{$qty} @ Rp {$price} = Rp {$subtotal}\n";
        }
        $invoiceNo = $sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT);
        $dateTime = $sale->sold_at ? $sale->sold_at->format('d/m/Y H:i') : $sale->created_at->format('d/m/Y H:i');
        $cashier = $sale->cashier ? $sale->cashier->name : 'System';
        $storeName = $sale->store?->name ?? '-';
        $storeCode = $sale->store?->code ?? '-';
        $storeCategory = $sale->store?->store_category ?? '-';
        $paymentMethod = ucfirst($sale->payment_method ?? 'Cash');
        $totalAmount = number_format($sale->total_amount, 0, ',', '.');
        $amountReceived = isset($sale->amount_received) && $sale->amount_received > 0 ? number_format($sale->amount_received, 0, ',', '.') : null;
        $changeDue = isset($sale->amount_received) && $sale->amount_received > 0 ? number_format($sale->amount_received - $sale->total_amount, 0, ',', '.') : null;

        $receiptJson = json_encode([
            '================================',
            '     *TOKO MAINAN ABCD*',
            '  Jl. Jendral Sudirman No. 123',
            '  Purwokerto, Indonesia 12345',
            '   Telp: 08123456789',
            '================================',
            '',
            'Invoice: *' . $invoiceNo . '*',
            'Tanggal: ' . $dateTime,
            'Kasir: ' . $cashier,
            'Store: ' . $storeName,
            'Store Info: ' . $storeCode . ' / ' . $storeCategory,
            'Pembayaran: ' . $paymentMethod,
            '',
            '--------------------------------',
            '  *DETAIL PEMBELIAN*',
            '--------------------------------',
            trim($itemsText) . "\n--------------------------------",
            '*TOTAL: Rp ' . $totalAmount . '*',
            ...($amountReceived ? ['Dibayar: Rp ' . $amountReceived, 'Kembalian: Rp ' . $changeDue] : []),
            '',
            '================================',
            '  Terima kasih atas pembelian',
            '  Anda!',
            '================================',
        ], JSON_UNESCAPED_UNICODE);
    @endphp

    {{-- blade-formatter-disable --}}
    <script>function whatsappReceipt() { var r = {!! $receiptJson !!}; return { showModal: false, phoneNumber: '', receiptText: r.join('\n'), sendWhatsApp: function () { if (!this.phoneNumber || this.phoneNumber.length < 9) { alert('Masukkan nomor WhatsApp yang valid!'); return; } var p = this.phoneNumber.replace(/\D/g, ''); if (p.startsWith('0')) { p = p.substring(1); } if (!p.startsWith('62')) { p = '62' + p; } var m = encodeURIComponent(this.receiptText); window.open('https://wa.me/' + p + '?text=' + m, '_blank'); this.showModal = false; } }; }
    </script>
    {{-- blade-formatter-enable --}}
</div>
