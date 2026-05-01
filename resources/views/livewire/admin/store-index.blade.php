<div wire:key="store-index-root" class="animate-in fade-in duration-300 relative w-full pb-10">
    <nav class="flex items-center space-x-1.5 text-sm font-medium mb-4" aria-label="Breadcrumb">
        <span class="text-gray-400">Products</span>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-800">Store</span>
    </nav>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Store</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data store yang digunakan di produk dan POS</p>
        </div>

        <a href="{{ route('admin.stores.create') }}" wire:navigate
            class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Store
        </a>
    </div>

    <form method="GET" action="{{ url()->current() }}"
        class="mb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex w-full sm:w-auto items-center gap-2">
            <div class="relative flex-1 sm:w-[320px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                    class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                    placeholder="Cari Store...">
            </div>
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-3.5 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Cari</span>
            </button>
        </div>
    </form>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mt-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th scope="col" class="w-10 px-3 py-2 text-center border-r border-gray-200">
                            <input type="checkbox"
                                class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </th>
                        <th scope="col"
                            class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span>Store ID</span>
                            </div>
                        </th>
                        <th scope="col"
                            class="w-px whitespace-nowrap px-1 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5">
                                    </path>
                                </svg>
                                <span>Kategori Store</span>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 sm:w-auto min-w-[180px]">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                    </path>
                                </svg>
                                <span>Nama Store</span>
                            </div>
                        </th>
                        <th scope="col"
                            class="hidden md:table-cell px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 w-1/3">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                </svg>
                                <span>Alamat</span>
                            </div>
                        </th>
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
                        <th scope="col" class="px-3 py-2 text-center w-20 text-gray-400">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                </path>
                            </svg>
                        </th>
                    </tr>
                </thead>
                @forelse ($storeGroups as $letter => $groupStores)
                    <tbody x-data="{ open: true }" class="divide-y divide-gray-200 bg-white">
                        <tr class="bg-gray-100">
                            <td colspan="7" class="px-3 py-2">
                                <button type="button"
                                    class="flex w-full items-center justify-between text-xs font-semibold text-gray-600 uppercase tracking-widest"
                                    @click="open = !open" x-bind:aria-expanded="open">
                                    <span>{{ $letter }}</span>
                                    <svg class="h-4 w-4 text-gray-400 transition-transform" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        x-bind:class="open ? 'rotate-180' : ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @foreach ($groupStores as $store)
                            <tr x-show="open" x-cloak wire:key="store-row-{{ $store->id }}"
                                class="hover:bg-gray-50 cursor-default transition-colors group">
                                <td class="px-3 py-2.5 text-center border-r border-gray-200">
                                    <input type="checkbox"
                                        class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                    <span
                                        class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded text-[11px] font-mono tracking-tight font-semibold border border-gray-200/50">
                                        {{ $store->code }}
                                    </span>
                                </td>
                                <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-100 shadow-sm leading-none">
                                        {{ $store->store_category }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 border-r border-gray-200">
                                    <span class="text-[13px] font-semibold text-gray-900 block truncate">{{ $store->name }}</span>
                                </td>
                                <td class="hidden md:table-cell px-3 py-2.5 border-r border-gray-200">
                                    <span class="text-[13px] text-gray-500 block truncate max-w-xs"
                                        title="{{ $store->address }}">{{ $store->address }}</span>
                                </td>
                                <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 text-center">
                                    <button wire:click="toggleActive({{ $store->id }})" class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase transition-all
                                                {{ $store->is_active
                            ? 'bg-emerald-50 text-emerald-700 border border-emerald-100/50 hover:bg-emerald-100'
                            : 'bg-slate-100 text-slate-500 border border-slate-200/60 hover:bg-slate-200 shadow-sm' }}">
                                        <span class="flex items-center gap-1.5">
                                            {{ $store->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </button>
                                </td>
                                <td class="px-3 py-2.5 text-center w-24 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.stores.edit', $store->id) }}" wire:navigate title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white border border-gray-200 rounded-lg shadow-sm text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all focus:outline-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <button type="button"
                                            @click="$dispatch('open-delete-modal', { name: '{{ addslashes($store->name) }}', url: '{{ route('admin.stores.destroy', $store->id) }}' })"
                                            title="Delete"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white border border-gray-200 rounded-lg shadow-sm text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all focus:outline-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @empty
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr>
                            <td colspan="7" class="px-3 py-10 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada store</h3>
                                <p class="mt-1 text-xs text-gray-500">Silakan tambahkan store baru.</p>
                            </td>
                        </tr>
                    </tbody>
                @endforelse
            </table>
        </div>

        @if ($stores->hasPages())
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
                {{ $stores->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>

    <div x-data="{ open: false, itemName: '', deleteUrl: '' }"
        x-on:open-delete-modal.window="open = true; itemName = $event.detail.name; deleteUrl = $event.detail.url"
        x-show="open" class="fixed inset-0 z-[99998] overflow-y-auto" style="display: none;">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="open = false"
                x-show="open" x-transition:outline></div>

            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">
                <div class="bg-white px-5 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.11 0 00-7.5 0" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Hapus Store</h3>
                            <div class="mt-2">
                                <p class="text-[14px] text-gray-500 font-medium">
                                    Apakah Anda yakin ingin menghapus store <strong x-text="itemName"
                                        class="text-gray-900"></strong>? Data ini akan dihapus permanen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto transition-all">
                            Hapus Sekarang
                        </button>
                    </form>
                    <button type="button" @click="open = false"
                        class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div x-data x-init="alert('{{ session('message') }}')"></div>
    @endif
</div>
