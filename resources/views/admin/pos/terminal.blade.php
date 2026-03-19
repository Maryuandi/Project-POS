@extends('layouts.admin')

@section('content')
    <div x-data="posSystem()" class="animate-in fade-in duration-300 relative w-full pb-8 flex flex-col lg:flex-row gap-6">

        <!-- Left Column: Products -->
        <div class="flex-1">
            <!-- Breadcrumbs Section -->
            <nav class="flex items-center space-x-1.5 text-[13px] font-medium mb-2" aria-label="Breadcrumb">
                <span class="text-gray-400">Transactions</span>
                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-600">Point of Sale</span>
            </nav>

            <!-- Header Section -->
            <div class="mb-5 flex flex-col sm:flex-row justify-between items-start xl:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Point of Sale</h1>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Buat transaksi baru dan kelola keranjang belanja.</p>
                </div>
            </div>

            <!-- Success Toast Notification -->
            @if (session()->has('message'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                    class="mb-4 p-4 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm font-bold text-emerald-800">{{ session('message') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Error Toast Notification -->
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    class="mb-4 p-4 rounded-lg bg-red-50 border border-red-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-bold text-red-800">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Toolbar Section (Search) -->
            <form action="{{ route('admin.pos.terminal') }}" method="GET" class="mb-6">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input name="search" type="text" value="{{ request('search') }}" autofocus onchange="this.form.submit()"
                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-[14px] font-medium bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all shadow-sm"
                        placeholder="Search products by name or code...">
                    @if(request('search'))
                        <a href="{{ route('admin.pos.terminal') }}"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Products Grid -->
            @if($products->isEmpty())
                <div class="bg-white border border-gray-200 rounded-lg p-10 text-center shadow-sm">
                    <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                    <p class="mt-1 text-xs text-gray-500">Try adjusting your search or filter.</p>
                </div>
            @else
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
                    @foreach($products as $product)
                        <div @click="addToCart({{ json_encode($product) }})"
                            class="bg-white border text-left border-gray-100/80 rounded-2xl overflow-hidden shadow-sm hover:border-blue-200 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 cursor-pointer group active:scale-[0.98] select-none flex flex-col h-full ring-1 ring-slate-900/5">

                            <!-- Image Area -->
                            <div
                                class="aspect-square bg-slate-50 flex items-center justify-center relative overflow-hidden border-b border-gray-100/50 shrink-0">
                                @if($product->image_path)
                                    <img src="{{ Str::startsWith($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                @endif

                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-white/70 backdrop-blur-sm flex items-center justify-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-[12px] font-bold border bg-red-50 text-red-700 border-red-200 shadow-sm leading-none tracking-wide uppercase">Habis</span>
                                    </div>
                                @elseif($product->stock <= 10)
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100/90 text-amber-800 border border-amber-200 shadow-sm leading-none backdrop-blur-sm">Sisa
                                            {{ $product->stock }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3
                                        class="text-[14px] font-bold text-gray-900 leading-snug line-clamp-2 mb-1.5 group-hover:text-blue-700 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-[12px] text-gray-500 font-medium">{{ $product->category->name ?? '-' }} &middot;
                                        {{ $product->code }}
                                    </p>
                                </div>
                                <div class="mt-3">
                                    <span class="text-[15px] font-black text-blue-700 tracking-tight">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column: Cart Sidebar -->
        <div class="w-full lg:w-[350px] xl:w-[400px] shrink-0">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm lg:sticky lg:top-4 flex flex-col"
                style="height: calc(100vh - 8rem);">

                <!-- Cart Header -->
                <div
                    class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-xl shrink-0">
                    <h2 class="text-sm font-bold text-gray-900 tracking-tight flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Current Ticket
                    </h2>
                    <button x-show="cart.length > 0" @click="clearCart()"
                        class="text-[12px] font-medium text-red-600 hover:text-red-700 transition-colors">Clear All</button>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto p-3 space-y-2 bg-white">
                    <template x-if="cart.length === 0">
                        <div class="h-full flex flex-col items-center justify-center text-gray-400 p-6 text-center">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <p class="text-[13px] font-medium text-gray-500">Cart is empty</p>
                        </div>
                    </template>
                    <template x-for="(item, index) in cart" :key="item.id">
                        <div
                            class="p-3 border border-gray-100 rounded-lg bg-gray-50/50 flex flex-col gap-2 relative group/item">
                            <div class="flex justify-between items-start gap-2 pr-4">
                                <span class="text-[13px] font-medium text-gray-900 leading-tight" x-text="item.name"></span>
                                <button @click="removeFromCart(index)"
                                    class="absolute top-3 right-3 text-gray-400 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-between items-end">
                                <div class="text-[11px] font-medium text-gray-500"
                                    x-text="'Rp ' + formatNumber(item.price)"></div>
                                <span class="text-[13px] font-bold text-gray-900 tracking-tight"
                                    x-text="'Rp ' + formatNumber(item.price * item.qty)"></span>
                            </div>
                            <div
                                class="flex items-center mt-1 border border-gray-200 rounded text-[12px] bg-white w-max overflow-hidden shadow-sm">
                                <button @click="decreaseQty(index)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100"><svg
                                        class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg></button>
                                <div class="px-3 font-semibold text-gray-900 text-center min-w-[2rem]" x-text="item.qty">
                                </div>
                                <button @click="increaseQty(index)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100"
                                    :disabled="item.qty >= item.stock"><svg class="w-3 h-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg></button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Cart Footer -->
                <div
                    class="border-t border-gray-100 bg-white p-4 rounded-b-xl shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.02)]">
                    <div class="space-y-1.5 mb-4">
                        <div class="flex justify-between items-center text-[13px] text-gray-500">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900" x-text="'Rp ' + formatNumber(total)"></span>
                        </div>
                        <div class="flex justify-between items-end pt-1">
                            <span class="text-[14px] font-bold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-blue-700 tracking-tight"
                                x-text="'Rp ' + formatNumber(total)"></span>
                        </div>
                    </div>
                    <button @click="openCheckout()" :disabled="cart.length === 0"
                        :class="cart.length === 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                        class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-lg text-sm font-semibold text-white transition-all shadow-sm">
                        <span>Charge</span>
                        <span x-show="cart.length > 0" class="opacity-50">•</span>
                        <span x-show="cart.length > 0" x-text="'Rp ' + formatNumber(total)"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Checkout Modal -->
        <div x-show="showCheckout" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100"
                    @click.away="showCheckout = false">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Payment Detail 🎉</h3>
                        <button @click="showCheckout = false" class="text-gray-400 hover:text-gray-500"><svg class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg></button>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Total Due</p>
                            <p class="text-3xl font-bold text-gray-900 tracking-tight" x-text="'Rp ' + formatNumber(total)">
                            </p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2">Payment Method</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <template x-for="method in ['cash', 'qris', 'transfer']">
                                        <button @click="paymentMethod = method"
                                            :class="paymentMethod === method ? 'border-blue-600 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-600'"
                                            class="rounded-lg border px-3 py-2 text-center text-[13px] font-medium transition-all"
                                            x-text="method.toUpperCase()"></button>
                                    </template>
                                </div>
                            </div>

                            <!-- Installment Toggle -->
                            <div class="p-3 rounded-lg border border-gray-100 bg-gray-50/50">
                                <label class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <span class="text-[13px] font-bold text-gray-700">Bayar Cicilan</span>
                                    </div>
                                    <div class="relative">
                                        <input type="checkbox" x-model="isInstallment" class="sr-only peer">
                                        <div
                                            class="w-9 h-5 bg-gray-300 peer-checked:bg-amber-500 rounded-full transition-colors">
                                        </div>
                                        <div
                                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-4 transition-transform">
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Installment: DP Input -->
                            <template x-if="isInstallment">
                                <div class="animate-in slide-in-from-top-2 duration-300">
                                    <label class="block text-[13px] font-bold text-gray-700 mb-2">DP / Bayar Dulu
                                        (Rp)</label>
                                    <input type="number" x-model.number="downPayment"
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-lg font-bold placeholder-gray-400 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all"
                                        placeholder="0" :max="total">
                                    <div class="mt-3 bg-amber-50 rounded-xl p-4 border border-amber-100 space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[13px] font-medium text-amber-700">Total Belanja</span>
                                            <span class="text-[13px] font-bold text-gray-900"
                                                x-text="'Rp ' + formatNumber(total)"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[13px] font-medium text-amber-700">DP</span>
                                            <span class="text-[13px] font-bold text-amber-600"
                                                x-text="'- Rp ' + formatNumber(downPayment || 0)"></span>
                                        </div>
                                        <div class="pt-2 border-t border-amber-200 flex items-center justify-between">
                                            <span class="text-[13px] font-bold text-amber-800">Sisa Tagihan</span>
                                            <span class="text-lg font-black text-amber-700"
                                                x-text="'Rp ' + formatNumber(Math.max(0, total - (downPayment || 0)))"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Cash: Amount Received (only when not installment) -->
                            <template x-if="paymentMethod === 'cash' && !isInstallment">
                                <div class="animate-in slide-in-from-top-2 duration-300">
                                    <label class="block text-[13px] font-bold text-gray-700 mb-2">Amount Received
                                        (Rp)</label>
                                    <input type="number" x-model.number="amountReceived"
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-lg font-bold placeholder-gray-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                        placeholder="0">
                                    <div
                                        class="mt-4 bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between shadow-sm">
                                        <span class="text-[13px] font-bold text-gray-600">Change Due</span>
                                        <span class="text-xl font-black"
                                            :class="changeDue >= 0 ? 'text-emerald-600' : 'text-red-500'"
                                            x-text="'Rp ' + formatNumber(Math.max(0, changeDue))"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-4 flex flex-row-reverse rounded-b-2xl border-t border-gray-100 gap-3">
                        <button @click="processPayment()"
                            :disabled="isProcessing || (!isInstallment && paymentMethod === 'cash' && amountReceived < total) || (isInstallment && (downPayment <= 0 || downPayment > total))"
                            :class="(isProcessing || (!isInstallment && paymentMethod === 'cash' && amountReceived < total) || (isInstallment && (downPayment <= 0 || downPayment > total))) ? 'bg-gray-400' : isInstallment ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-600 hover:bg-blue-700'"
                            class="inline-flex w-full justify-center rounded-lg px-4 py-2.5 text-[14px] font-semibold bg-blue-600 text-white shadow-sm transition-all sm:w-auto">
                            <svg x-show="isProcessing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span
                                x-text="isProcessing ? 'Processing...' : isInstallment ? 'Konfirmasi Cicilan' : 'Confirm Payment'"></span>
                        </button>
                        <button @click="showCheckout = false" :disabled="isProcessing"
                            class="inline-flex w-full justify-center rounded-lg bg-white px-4 py-2.5 text-[14px] font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function posSystem() {
            return {
                cart: [],
                search: '',
                showCheckout: false,
                paymentMethod: 'cash',
                amountReceived: 0,
                total: 0,
                isProcessing: false,
                isInstallment: false,
                downPayment: 0,

                addToCart(product) {
                    if (product.stock <= 0) return;
                    const index = this.cart.findIndex(i => i.id === product.id);
                    if (index !== -1) {
                        if (this.cart[index].qty < product.stock) {
                            this.cart[index].qty++;
                        }
                    } else {
                        this.cart.push({ ...product, qty: 1 });
                    }
                    this.calculateTotal();
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                    this.calculateTotal();
                },

                increaseQty(index) {
                    if (this.cart[index].qty < this.cart[index].stock) {
                        this.cart[index].qty++;
                        this.calculateTotal();
                    }
                },

                decreaseQty(index) {
                    if (this.cart[index].qty > 1) {
                        this.cart[index].qty--;
                    } else {
                        this.cart.splice(index, 1);
                    }
                    this.calculateTotal();
                },

                clearCart() {
                    this.cart = [];
                    this.calculateTotal();
                },

                calculateTotal() {
                    this.total = this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                openCheckout() {
                    this.amountReceived = this.total;
                    this.downPayment = 0;
                    this.isInstallment = false;
                    this.showCheckout = true;
                },

                get changeDue() {
                    return this.amountReceived - this.total;
                },

                async processPayment() {
                    if (this.isProcessing) return;
                    this.isProcessing = true;

                    try {
                        const response = await fetch('{{ route("admin.pos.checkout") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                cart: this.cart,
                                payment_method: this.paymentMethod,
                                amount_received: this.amountReceived,
                                is_installment: this.isInstallment,
                                down_payment: this.downPayment
                            })
                        });

                        const result = await response.json();

                        if (response.ok) {
                            window.location.href = '{{ route("admin.pos.terminal") }}';
                        } else {
                            console.error('Checkout Error:', result);

                            let errorMsg = result.message || 'Payment failed';
                            if (result.errors) {
                                errorMsg += '\n' + Object.values(result.errors).flat().join('\n');
                            }

                            alert('🚨 Ouch! Ada masalah:\n' + errorMsg);
                            this.isProcessing = false;
                        }
                    } catch (error) {
                        console.error('Connection Error:', error);
                        alert('❌ Gagal terhubung ke server. Coba cek koneksi internet atau server backend kamu.');
                        this.isProcessing = false;
                    }
                },

                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                }
            }
        }
    </script>
@endsection