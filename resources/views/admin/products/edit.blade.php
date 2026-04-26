@extends('layouts.admin')

@section('content')
<div class="animate-in fade-in duration-300 relative w-full pb-10" x-data="productForm()">
    <!-- Breadcrumbs Section -->
    <nav class="flex items-center space-x-1.5 text-[13px] font-medium mb-4" aria-label="Breadcrumb">
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">Products</a>
        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-900 font-semibold">Edit Product</span>
    </nav>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Product</h1>
            <p class="text-sm text-gray-500 mt-1">Update details for "<strong>{{ $product->name }}</strong>"</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
            Back to Products
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" @submit="isSubmitting = true">
            @csrf
            @method('PUT')
            <div class="px-6 py-6 pb-8 space-y-6">

                @if ($errors->any())
                    <div class="p-4 rounded-md bg-red-50 border border-red-200">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-sm font-semibold text-red-800">Ups, ada form yang belum diisi dengan benar! Cek pesan merah di bawah.</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                    <!-- Basic Information -->
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="text-xs font-semibold text-gray-500 tracking-wider uppercase mb-3">Basic Information</h3>
                    </div>

                    <div class="col-span-1 border-b pb-4 md:border-b-0 md:pb-0 border-gray-100">
                        <label for="name" class="block text-[13px] font-medium text-gray-700 mb-1.5">Product Name</label>
                        <input type="text" id="name" name="name" x-model="name" @input="generateCode"
                            class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-[14px] transition-shadow shadow-sm @error('name') border-red-500 @enderror"
                            placeholder="e.g. Vintage Action Figure">
                        @error('name') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-1 border-b pb-4 md:border-b-0 md:pb-0 border-gray-100">
                        <label for="code" class="block text-[13px] font-medium text-gray-700 mb-1.5">Product Code (SKU - Auto)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 text-sm">#</span>
                            <input type="text" id="code" name="code" x-model="code" readonly
                                class="block w-full rounded-md border-gray-200 bg-gray-50 py-2 pl-9 pr-3 text-gray-500 font-mono text-[13px] cursor-not-allowed focus:outline-none">
                        </div>
                        @error('code') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-1 border-b pb-4 md:border-b-0 md:pb-0 border-gray-100">
                        <label for="distributor" class="block text-[13px] font-medium text-gray-700 mb-1.5">Distributor (Optional)</label>
                        <input type="text" id="distributor" name="distributor" value="{{ old('distributor', $product->distributor) }}"
                            class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-[14px] shadow-sm"
                            placeholder="e.g. PT. Sumber Makmur">
                        @error('distributor') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="col-span-1 md:col-span-2 pt-2">
                        <h3 class="text-xs font-semibold text-gray-500 tracking-wider uppercase mb-3">Inventory & Cost</h3>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="stock" class="block text-[13px] font-medium text-gray-700 mb-1.5">Stock Quantity</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                            class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-[14px] shadow-sm"
                            placeholder="0">
                        @error('stock') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="notes" class="block text-[13px] font-medium text-gray-700 mb-1.5">Catatan Perubahan (Notes)</label>
                        <textarea id="notes" name="notes" rows="2"
                            class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-[14px] shadow-sm transition-shadow"
                            placeholder="Contoh: Tambah stok dari distributor, koreksi data, dll.">{{ old('notes') }}</textarea>
                        <p class="text-[11px] text-gray-400 mt-1.5 leading-relaxed italic">Catatan ini akan tersimpan di riwayat stok (Stock History) jika Anda mengubah jumlah stok di atas.</p>
                        @error('notes') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="cost" class="block text-[13px] font-medium text-gray-700 mb-1.5">Harga Beli (Cost Price)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 font-medium text-sm">Rp</span>
                            <input type="number" id="cost" name="cost" x-model="cost" min="0" step="1"
                                class="block w-full rounded-md border-gray-300 py-2 pl-9 pr-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-[14px] shadow-sm"
                                placeholder="0">
                        </div>
                        @error('cost') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2 pt-2 border-t border-gray-100 mt-4">
                        <label class="flex items-center space-x-3 cursor-pointer group w-max">
                            <div class="relative flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-600 focus:ring-2 cursor-pointer transition-colors">
                            </div>
                            <div>
                                <span class="text-[13px] font-medium text-gray-900 group-hover:text-blue-600 transition-colors">Product is Active</span>
                                <p class="text-[12px] text-gray-500 mt-0.5">Toggle this if you want to temporarily hide the product from POS screens.</p>
                            </div>
                        </label>
                    </div>

                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end">
                <button type="submit" :disabled="isSubmitting" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!isSubmitting">Save Changes</span>
                    <span x-show="isSubmitting" style="display: none;">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function productForm() {
        return {
            name: '{{ old('name', addslashes($product->name)) }}',
            code: '{{ old('code', $product->code) }}',
            cost: {{ old('cost', $product->cost) }},
            isSubmitting: false,

            generateCode() {
                if (!this.code && this.name) {
                    const initials = this.name.split(' ')
                        .filter(word => word.length > 0)
                        .map(word => word[0].toUpperCase())
                        .join('');

                    if (initials) {
                        this.code = initials + '-' + Math.floor(Math.random() * 9000 + 1000);
                    }
                }
            }
        }
    }
</script>
@endsection
