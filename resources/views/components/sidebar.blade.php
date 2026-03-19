@props(['activeRoute' => null])

<div
    class="fixed inset-y-0 z-10 hidden h-svh w-[--sidebar-width] transition-[left,right,width] duration-150 ease-in-out will-change-transform md:flex left-0 group-data-[collapsible=true]:left-[calc(var(--sidebar-width)*-1)] border-r border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-925">
    <div data-sidebar="sidebar" class="bg-sidebar flex h-full w-full flex-col">
        <!-- Header -->
        <div data-sidebar="header" class="flex flex-col gap-2 p-2 px-3 py-4">
            <div class="flex items-center gap-3">
                <span
                    class="flex size-9 items-center justify-center rounded-md bg-white p-1.5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-800">
                    <svg fill="currentColor" viewBox="0 0 133 133" class="size-6 text-blue-500 dark:text-blue-500">
                        <path
                            d="M54.75 17.8947C54.75 38.1912 38.2965 54.6447 18 54.6447V79.1447H54.75V115.895H79.25C79.25 95.5981 95.7034 79.1447 116 79.1447V54.6447H79.25V17.8947H54.75Z">
                        </path>
                    </svg>
                </span>
                <div>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-gray-50">PointSale POS</span>
                    <span class="block text-xs text-gray-900 dark:text-gray-50">Premium Starter Plan</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div data-sidebar="content" class="flex min-h-0 flex-1 flex-col gap-2 overflow-auto no-scrollbar">
            <!-- Search -->
            <div data-sidebar="group" class="relative flex w-full min-w-0 flex-col p-3">
                <div data-sidebar="group-content" class="w-full text-sm">
                    <div class="relative w-full [&>input]:sm:py-1.5" tremor-id="tremor-raw">
                        <input type="search"
                            class="relative block w-full appearance-none rounded-md border px-2.5 py-2 shadow-sm outline-none transition sm:text-sm border-gray-300 dark:border-gray-800 text-gray-900 dark:text-gray-50 placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-950 disabled:border-gray-300 disabled:bg-gray-100 disabled:text-gray-400 disabled:dark:border-gray-700 disabled:dark:bg-gray-800 disabled:dark:text-gray-500 focus:ring-2 focus:ring-blue-200 focus:dark:ring-blue-700/30 focus:border-blue-500 focus:dark:border-blue-700 pl-8"
                            placeholder="Search items...">
                        <div
                            class="pointer-events-none absolute bottom-0 left-2 flex h-full items-center justify-center text-gray-400 dark:text-gray-600">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" aria-hidden="true" class="remixicon size-[1.125rem] shrink-0">
                                <path
                                    d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Primary Menu -->
            <div data-sidebar="group" class="relative flex w-full min-w-0 flex-col p-3 pt-0">
                <div data-sidebar="group-content" class="w-full text-sm">
                    <ul data-sidebar="menu" class="flex w-full min-w-0 flex-col gap-1 space-y-1">
                        <li>
                            <a data-active="{{ request()->routeIs('dashboard') ? 'true' : 'false' }}" wire:navigate
                                class="flex items-center justify-between rounded-md p-2 text-base transition hover:bg-gray-200/50 sm:text-sm hover:dark:bg-gray-900 text-gray-900 dark:text-gray-400 hover:dark:text-gray-50 data-[active=true]:text-blue-600 data-[active=true]:dark:text-blue-500 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                href="{{ route('dashboard') }}">
                                <span class="flex items-center gap-x-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-house size-[18px] shrink-0"
                                        aria-hidden="true">
                                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                                        <path
                                            d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z">
                                        </path>
                                    </svg>
                                    Home
                                </span>
                            </a>
                        </li>
                        <li>
                            <a data-active="false"
                                class="flex items-center justify-between rounded-md p-2 text-base transition hover:bg-gray-200/50 sm:text-sm hover:dark:bg-gray-900 text-gray-900 dark:text-gray-400 hover:dark:text-gray-50 data-[active=true]:text-blue-600 data-[active=true]:dark:text-blue-500 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                href="#">
                                <span class="flex items-center gap-x-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-package-search size-[18px] shrink-0" aria-hidden="true">
                                        <path
                                            d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14">
                                        </path>
                                        <path d="m7.5 4.27 9 5.15"></path>
                                        <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                        <line x1="12" x2="12" y1="22" y2="12"></line>
                                        <circle cx="18.5" cy="15.5" r="2.5"></circle>
                                        <path d="M20.27 17.27 22 19"></path>
                                    </svg>
                                    Inbox
                                </span>
                                <span
                                    class="inline-flex size-5 items-center justify-center rounded bg-blue-100 text-sm font-medium text-blue-600 sm:text-xs dark:bg-blue-500/10 dark:text-blue-500">2</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Separator -->
            <div class="px-3">
                <div class="mx-auto flex w-full items-center justify-between gap-3 text-sm text-gray-500 dark:text-gray-500 my-0 py-0"
                    tremor-id="tremor-raw">
                    <div class="h-[1px] w-full bg-gray-200 dark:bg-gray-800"></div>
                </div>
            </div>

            <!-- Collapsible Groups -->
            <div data-sidebar="group" class="relative flex w-full min-w-0 flex-col p-3">
                <div data-sidebar="group-content" class="w-full text-sm">
                    <ul data-sidebar="menu" class="flex w-full min-w-0 flex-col gap-1 space-y-4">
                        <!-- Sales Group -->
                        <li x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex w-full items-center justify-between gap-x-2.5 rounded-md p-2 text-base text-gray-900 transition hover:bg-gray-200/50 sm:text-sm dark:text-gray-400 hover:dark:bg-gray-900 hover:dark:text-gray-50 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500">
                                <div class="flex items-center gap-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-book-text size-[18px] shrink-0"
                                        aria-hidden="true">
                                        <path
                                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20">
                                        </path>
                                        <path d="M8 11h8"></path>
                                        <path d="M8 7h6"></path>
                                    </svg>
                                    Sales
                                </div>
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" aria-hidden="true" :class="open ? '-rotate-180' : ''"
                                    class="remixicon rotate-0 size-5 shrink-0 transform text-gray-400 transition-transform duration-150 ease-in-out dark:text-gray-600">
                                    <path d="M12 16L6 10H18L12 16Z"></path>
                                </svg>
                            </button>
                            <ul x-show="open" x-transition data-sidebar="menu-sub"
                                class="relative space-y-1 border-l border-transparent mt-1">
                                <div class="absolute inset-y-0 left-4 w-px bg-gray-300 dark:bg-gray-800"></div>
                                <li>
                                    <a data-active="false"
                                        class="relative flex gap-2 rounded-md py-1.5 pl-9 pr-3 text-base transition sm:text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-50 data-[active=true]:rounded data-[active=true]:bg-white data-[active=true]:text-blue-600 data-[active=true]:shadow data-[active=true]:ring-1 data-[active=true]:ring-gray-200 data-[active=true]:dark:bg-gray-900 data-[active=true]:dark:text-blue-500 data-[active=true]:dark:ring-gray-800 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                        href="#">
                                        Quotes
                                    </a>
                                </li>
                                <li>
                                    <a data-active="false"
                                        class="relative flex gap-2 rounded-md py-1.5 pl-9 pr-3 text-base transition sm:text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-50 data-[active=true]:rounded data-[active=true]:bg-white data-[active=true]:text-blue-600 data-[active=true]:shadow data-[active=true]:ring-1 data-[active=true]:ring-gray-200 data-[active=true]:dark:bg-gray-900 data-[active=true]:dark:text-blue-500 data-[active=true]:dark:ring-gray-800 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                        href="#">
                                        Orders
                                    </a>
                                </li>
                                <li>
                                    <a data-active="false"
                                        class="relative flex gap-2 rounded-md py-1.5 pl-9 pr-3 text-base transition sm:text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-50 data-[active=true]:rounded data-[active=true]:bg-white data-[active=true]:text-blue-600 data-[active=true]:shadow data-[active=true]:ring-1 data-[active=true]:ring-gray-200 data-[active=true]:dark:bg-gray-900 data-[active=true]:dark:text-blue-500 data-[active=true]:dark:ring-gray-800 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                        href="#">
                                        Insights & Reports
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Products Group -->
                        <li
                            x-data="{ open: {{ (request()->is('admin/products*') || request()->is('admin/categories*')) ? 'true' : 'false' }} }">
                            <button @click="open = !open"
                                class="flex w-full items-center justify-between gap-x-2.5 rounded-md p-2 text-base text-gray-900 transition hover:bg-gray-200/50 sm:text-sm dark:text-gray-400 hover:dark:bg-gray-900 hover:dark:text-gray-50 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500">
                                <div class="flex items-center gap-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-package-search size-[18px] shrink-0" aria-hidden="true">
                                        <path
                                            d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14">
                                        </path>
                                        <path d="m7.5 4.27 9 5.15"></path>
                                        <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                        <line x1="12" x2="12" y1="22" y2="12"></line>
                                        <circle cx="18.5" cy="15.5" r="2.5"></circle>
                                        <path d="M20.27 17.27 22 19"></path>
                                    </svg>
                                    Inventory
                                </div>
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" aria-hidden="true" :class="open ? '-rotate-180' : ''"
                                    class="remixicon rotate-0 size-5 shrink-0 transform text-gray-400 transition-transform duration-150 ease-in-out dark:text-gray-600">
                                    <path d="M12 16L6 10H18L12 16Z"></path>
                                </svg>
                            </button>
                            <ul x-show="open" x-transition data-sidebar="menu-sub"
                                class="relative space-y-1 border-l border-transparent mt-1">
                                <div class="absolute inset-y-0 left-4 w-px bg-gray-300 dark:bg-gray-800"></div>
                                <li>
                                    <a data-active="{{ request()->is('admin/products*') ? 'true' : 'false' }}"
                                        wire:navigate
                                        class="relative flex gap-2 rounded-md py-1.5 pl-9 pr-3 text-base transition sm:text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-50 data-[active=true]:rounded data-[active=true]:bg-white data-[active=true]:text-blue-600 data-[active=true]:shadow data-[active=true]:ring-1 data-[active=true]:ring-gray-200 data-[active=true]:dark:bg-gray-900 data-[active=true]:dark:text-blue-500 data-[active=true]:dark:ring-gray-800 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                        href="{{ route('admin.products.index') }}">
                                        @if(request()->is('admin/products*'))
                                            <div class="absolute left-4 top-1/2 h-5 w-px -translate-y-1/2 bg-blue-500 dark:bg-blue-500"
                                                aria-hidden="true"></div>
                                        @endif
                                        Items
                                    </a>
                                </li>
                                <li>
                                    <a data-active="{{ request()->is('admin/categories*') ? 'true' : 'false' }}"
                                        wire:navigate
                                        class="relative flex gap-2 rounded-md py-1.5 pl-9 pr-3 text-base transition sm:text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-50 data-[active=true]:rounded data-[active=true]:bg-white data-[active=true]:text-blue-600 data-[active=true]:shadow data-[active=true]:ring-1 data-[active=true]:ring-gray-200 data-[active=true]:dark:bg-gray-900 data-[active=true]:dark:text-blue-500 data-[active=true]:dark:ring-gray-800 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                        href="{{ route('admin.categories.index') }}">
                                        @if(request()->is('admin/categories*'))
                                            <div class="absolute left-4 top-1/2 h-5 w-px -translate-y-1/2 bg-blue-500 dark:bg-blue-500"
                                                aria-hidden="true"></div>
                                        @endif
                                        Categories
                                    </a>
                                </li>
                                <li>
                                    <a data-active="false"
                                        class="relative flex gap-2 rounded-md py-1.5 pl-9 pr-3 text-base transition sm:text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-50 data-[active=true]:rounded data-[active=true]:bg-white data-[active=true]:text-blue-600 data-[active=true]:shadow data-[active=true]:ring-1 data-[active=true]:ring-gray-200 data-[active=true]:dark:bg-gray-900 data-[active=true]:dark:text-blue-500 data-[active=true]:dark:ring-gray-800 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                                        href="#">
                                        Suppliers
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div data-sidebar="footer" class="flex flex-col gap-2 p-3">
            <div class="border-t border-gray-200 dark:border-gray-800"></div>
            <button
                class="relative whitespace-nowrap border text-center transition-all duration-100 ease-in-out disabled:pointer-events-none disabled:shadow-none shadow-none border-transparent dark:text-gray-50 bg-transparent disabled:text-gray-400 disabled:dark:text-gray-600 group flex w-full items-center justify-between rounded-md px-1 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200/50 data-[state=open]:bg-gray-200/50 hover:dark:bg-gray-800/50 data-[state=open]:dark:bg-gray-900 outline outline-offset-2 outline-0 focus-visible:outline-2 outline-blue-500 dark:outline-blue-500"
                tremor-id="tremor-raw" aria-label="User settings" type="button" id="radix-:r0:" aria-haspopup="menu"
                aria-expanded="false" data-state="closed">
                <span class="flex items-center gap-3">
                    <span
                        class="flex size-8 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white text-xs text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300"
                        aria-hidden="true">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                    </span>
                    <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevrons-up-down size-4 shrink-0 text-gray-500 group-hover:text-gray-700 group-hover:dark:text-gray-400"
                    aria-hidden="true">
                    <path d="m7 15 5 5 5-5"></path>
                    <path d="m7 9 5-5 5 5"></path>
                </svg>
            </button>
        </div>
    </div>
</div>