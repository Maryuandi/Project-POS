@extends('layouts.admin')

@section('content')
    <div class="animate-in fade-in duration-300 relative w-full pb-10" x-data="categoryForm()">

        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-1.5 text-[13px] font-medium mb-2" aria-label="Breadcrumb">
            <a href="{{ route('admin.categories.index') }}"
                class="text-gray-400 hover:text-gray-600 transition-colors">Categories</a>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-500 font-bold uppercase tracking-widest text-[11px]">Edit Category</span>
        </nav>

        <!-- Header -->
        <div class="mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Category</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Update category details for
                    "<strong>{{ $category->name }}</strong>"</p>
            </div>
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Back to Categories
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                @submit="isSubmitting = true">
                @csrf
                @method('PUT')

                <div class="px-6 py-6 pb-8 space-y-6">

                    @if ($errors->any())
                        <div class="p-4 rounded-md bg-red-50 border border-red-200">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm font-semibold text-red-800 tracking-tight">Ups, ada form yang belum diisi
                                    dengan benar! Cek pesan merah di bawah.</span>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                        <!-- Basic Information -->
                        <div class="col-span-1 md:col-span-2">
                            <h3
                                class="text-xs font-semibold text-gray-400 tracking-widest uppercase mb-4 py-2 border-b border-gray-50">
                                Category Information</h3>
                        </div>

                        <!-- Category Name -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="name"
                                class="block text-[13px] font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Category
                                Name</label>
                            <input type="text" id="name" name="name" x-model="name" @input="generateCode"
                                class="block w-full rounded-md border-gray-300 py-2.5 px-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-[14px] transition-shadow shadow-sm @error('name') border-red-500 bg-red-50/10 @enderror"
                                placeholder="e.g. Action Figures">
                            @error('name') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Category Code -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="code"
                                class="block text-[13px] font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Category
                                Code (SKU)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-[14px] font-mono font-bold">#</span>
                                </div>
                                <input type="text" id="code" name="code" x-model="code" readonly
                                    class="block w-full rounded-md border-gray-200 bg-gray-50 py-2.5 pl-8 pr-3 text-gray-500 text-[14px] font-mono cursor-not-allowed focus:outline-none shadow-inner"
                                    placeholder="Auto-generated SKU...">
                            </div>
                            @error('code') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status Toggle Card -->
                        <div class="col-span-1 md:col-span-2">
                            <div class="bg-gray-50/80 rounded-xl border border-gray-200/60 p-5 hover:bg-white hover:shadow-md hover:border-blue-100 transition-all cursor-pointer group"
                                onclick="document.getElementById('is_active').click()">
                                <label class="flex items-center space-x-4 cursor-pointer">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5 text-blue-500 group-hover:text-white" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <span
                                            class="text-[14px] font-bold text-gray-900 group-hover:text-blue-600 transition-colors uppercase tracking-tight">Active
                                            Category</span>
                                        <p class="text-[12px] text-gray-500 mt-0.5 leading-relaxed">Category ini bakal
                                            nongol dan bisa dipake di Kasir (POS) maupun List Produk.</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                            class="w-5 h-5 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-600 focus:ring-offset-2 cursor-pointer transition-all">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-5 py-2.5 font-bold text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all text-sm shadow-sm uppercase tracking-wide">
                        Cancel
                    </a>
                    <button type="submit" :disabled="isSubmitting"
                        class="inline-flex items-center px-6 py-2.5 font-bold text-white bg-blue-600 border border-blue-700 rounded-lg shadow-[0_4px_10px_rgb(37,99,235,0.3)] hover:bg-blue-700 hover:shadow-none focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all text-sm uppercase tracking-widest disabled:opacity-70 disabled:cursor-not-allowed group">
                        <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" style="display: none;"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <span x-show="!isSubmitting">Save Changes</span>
                        <span x-show="isSubmitting" style="display: none;">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function categoryForm() {
            return {
                name: '{{ old('name', addslashes($category->name)) }}',
                code: '{{ old('code', $category->code) }}',
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