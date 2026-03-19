@extends('layouts.admin')

@section('content')
    <div class="animate-in fade-in duration-300 relative w-full pb-10">

        <!-- Breadcrumbs Section -->
        <nav class="flex items-center space-x-1.5 text-[13px] font-medium mb-2" aria-label="Breadcrumb">
            <span class="text-gray-400">Categories</span>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </nav>

        <!-- Header Section -->
        <div class="mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Categories</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Manage your product categories</p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add category
            </a>
        </div>

        <!-- Success Alert -->
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

        <!-- Toolbar Section (Search) -->
        <form action="{{ route('admin.categories.index') }}" method="GET" class="mb-4">
            <div class="flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4">
                <!-- Left: Search input -->
                <div class="flex items-center gap-2 w-full xl:w-auto">
                    <div class="relative w-full xl:w-[320px]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input name="search" type="text" value="{{ request('search') }}"
                            class="block w-full pl-9 pr-3 py-1.5 border border-gray-300 rounded-md text-[13px] bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                            placeholder="Search categories..." onchange="this.form.submit()">
                    </div>
                    <button type="submit"
                        class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm">Search</button>
                </div>

                <!-- Right: Action Icons (Reset) -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.categories.index') }}"
                        class="p-1.5 border border-gray-300 bg-white rounded-md text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors shadow-sm"
                        title="Clear Search">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </form>

        <!-- Data Grid Table Section -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm mt-2">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th scope="col" class="w-10 px-3 py-2 text-center border-r border-gray-200">
                                <input type="checkbox"
                                    class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            </th>
                            <th scope="col" class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                                Category</th>
                            <th scope="col" class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">SKU
                                Code</th>
                            <th scope="col" class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                                Status</th>
                            <th scope="col" class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                                Added</th>
                            <th scope="col" class="px-3 py-2 text-center w-12 text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 cursor-default transition-colors group">
                                <td class="px-3 py-2.5 text-center border-r border-gray-200">
                                    <input type="checkbox"
                                        class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="px-3 py-2.5 border-r border-gray-200">
                                    <div class="flex items-center space-x-2.5">
                                        <div
                                            class="w-6 h-6 rounded-md bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 truncate">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-2.5 border-r border-gray-200">
                                    <span class="text-sm font-mono text-gray-500">#{{ $category->code }}</span>
                                </td>
                                <td class="px-3 py-2.5 border-r border-gray-200">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium transition-colors {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 border-r border-gray-200 text-sm text-gray-600">
                                    {{ $category->created_at->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-3 py-2.5 text-right w-20">
                                    <div class="flex items-center justify-end gap-1.5" x-data="{ confirmingDeletion: false }">
                                        <a href="{{ route('admin.categories.edit', $category) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white border border-gray-200 rounded-md shadow-sm text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all focus:outline-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <button @click="confirmingDeletion = true" type="button" title="Delete"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white border border-gray-200 rounded-md shadow-sm text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all focus:outline-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>

                                        <template x-if="confirmingDeletion">
                                            <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title"
                                                role="dialog" aria-modal="true">
                                                <div
                                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity"
                                                        @click="confirmingDeletion = false"></div>
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                        aria-hidden="true">&#8203;</span>
                                                    <div
                                                        class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full animate-in zoom-in-95 duration-200">
                                                        <div class="bg-white px-6 pt-6 pb-4 text-center sm:text-left">
                                                            <div class="sm:flex sm:items-start">
                                                                <div
                                                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                                                                    <svg class="h-6 w-6 text-red-600" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                    </svg>
                                                                </div>
                                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                    <h3 class="text-lg leading-6 font-bold text-gray-900"
                                                                        id="modal-title">Hapus Kategori?</h3>
                                                                    <div class="mt-2 text-sm text-gray-500">Apakah Anda yakin
                                                                        ingin menghapus <span
                                                                            class="font-semibold text-gray-900">"{{ $category->name }}"</span>?
                                                                        Data ini akan dihapus permanen.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-gray-50/50 px-6 py-4 flex flex-row-reverse gap-3">
                                                            <form
                                                                action="{{ route('admin.categories.destroy', $category->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm transition-colors">Ya,
                                                                    Hapus</button>
                                                            </form>
                                                            <button type="button" @click="confirmingDeletion = false"
                                                                class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm transition-colors">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-10 text-center text-sm text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="px-6 py-3 border-t border-gray-200 bg-gray-50/50">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection