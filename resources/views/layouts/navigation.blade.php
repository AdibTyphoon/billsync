<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 shadow-sm shadow-slate-900/[0.03] backdrop-blur-xl">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-[4.25rem] justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-lg font-black text-white shadow-md shadow-indigo-600/20">B</span>
                        <span class="text-lg font-extrabold tracking-tight text-slate-950">BillSync</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden items-center gap-2 sm:ms-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('monitored-billers')" :active="request()->routeIs('monitored-billers')">
                        {{ __('Monitored Billers') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown & ADMIN BUTTON -->
            <div class="hidden sm:flex sm:items-center sm:gap-4 sm:ms-6">
                
                <!-- BUTANG ADMIN PORTAL (HANYA UNTUK ADMIN) -->
                @if(auth()->id() == 1)
                <a href="{{ route('admin-portal') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                    <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Admin Portal
                </a>
                @endif

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-transparent bg-white px-3 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-200 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-700">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span>{{ Auth::user()->name }}</span>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" aria-label="Toggle account menu" :aria-expanded="open.toString()" class="inline-flex items-center justify-center rounded-xl p-2.5 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-100 bg-white sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('monitored-billers')" :active="request()->routeIs('monitored-billers')">
                {{ __('Monitored Billers') }}
            </x-responsive-nav-link>

            <!-- BUTANG ADMIN PORTAL UNTUK MOBILE (HANYA UNTUK ADMIN) -->
            @if(auth()->id() == 1)
            <div class="px-4 py-3 border-t border-gray-100">
                <a href="{{ route('admin-portal') }}" class="flex items-center justify-center w-full px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl shadow-sm hover:bg-gray-800 transition">
                    <svg class="w-4 h-4 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Access Admin Portal
                </a>
            </div>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>

<div class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200/90 bg-white/95 px-5 pb-[max(env(safe-area-inset-bottom),0.65rem)] pt-2 shadow-[0_-8px_30px_rgba(15,23,42,0.06)] backdrop-blur-xl sm:hidden">
        <div class="mx-auto grid max-w-md grid-cols-2 gap-2">
            <a href="{{ route('dashboard') }}" class="flex min-h-12 flex-col items-center justify-center gap-1 rounded-xl text-xs font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1V10Z"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('monitored-billers') }}" class="flex min-h-12 flex-col items-center justify-center gap-1 rounded-xl text-xs font-semibold transition {{ request()->routeIs('monitored-billers') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}" {{ request()->routeIs('monitored-billers') ? 'aria-current=page' : '' }}>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 1 4 16.5v-11ZM4 16.5A2.5 2.5 0 0 1 6.5 14H20M8 7h8m-8 3h5"></path></svg>
                Billers
            </a>
        </div>
    </div>
