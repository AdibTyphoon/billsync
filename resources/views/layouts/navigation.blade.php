<nav x-data="{ open: false }"
     @keydown.escape.window="open = false"
     class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 shadow-sm shadow-slate-900/[0.03] backdrop-blur-xl">
    <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-3">
            <div class="flex min-w-0 items-center gap-2 lg:gap-8">
                <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-2.5 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-lg font-black text-white shadow-md shadow-indigo-600/20" aria-hidden="true">B</span>
                    <span class="text-lg font-extrabold tracking-tight text-slate-950">BillSync</span>
                </a>

                <div class="hidden items-center gap-2 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('monitored-billers')" :active="request()->routeIs('monitored-billers')">
                        {{ __('Monitored Billers') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden items-center gap-3 lg:flex">
                @if(auth()->id() == 1)
                    <a href="{{ route('admin-portal') }}" class="inline-flex min-h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Admin Portal
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex min-h-10 items-center gap-2 rounded-xl border border-transparent bg-white px-2 py-1.5 text-sm font-semibold text-slate-600 transition hover:border-slate-200 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-700" aria-hidden="true">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="max-w-36 truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <button type="button"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                    aria-controls="mobile-navigation-menu"
                    aria-label="Toggle navigation menu"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 lg:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path :class="{ 'hidden': open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="mobile-navigation-menu"
             x-cloak
             x-show="open"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-1 scale-[.98]"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-1 scale-[.98]"
             @click.outside="open = false"
             class="absolute left-0 right-0 top-[calc(100%+0.75rem)] z-50 max-h-[calc(100svh-6rem)] overflow-y-auto rounded-2xl border border-slate-200 bg-white p-3 shadow-xl shadow-slate-950/15 lg:hidden">
            <div class="px-3 pb-2 pt-1">
                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-400">Navigation</p>
            </div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex min-h-11 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="h-5 w-5 shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1V10Z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('monitored-billers') }}" class="flex min-h-11 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('monitored-billers') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="h-5 w-5 shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 1 4 16.5v-11ZM4 16.5A2.5 2.5 0 0 1 6.5 14H20M8 7h8m-8 3h5"></path></svg>
                    Monitored Billers
                </a>
                @if(auth()->id() == 1)
                    <a href="{{ route('admin-portal') }}" class="flex min-h-11 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin-portal') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}">
                        <svg class="h-5 w-5 shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Admin Portal
                    </a>
                @endif
            </div>

            <div class="my-3 border-t border-slate-100"></div>

            <div class="rounded-xl bg-slate-50 px-3 py-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700" aria-hidden="true">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <a href="{{ route('profile.edit') }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0ZM5 21a7 7 0 0114 0"></path></svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white transition hover:bg-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M18 15l3-3m0 0l-3-3m3 3H9"></path></svg>
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200/90 bg-white/95 px-4 pb-[calc(env(safe-area-inset-bottom)+0.5rem)] pt-2 shadow-[0_-8px_30px_rgba(15,23,42,0.06)] backdrop-blur-xl lg:hidden">
    <div class="mx-auto grid max-w-md grid-cols-2 gap-2">
        <a href="{{ route('dashboard') }}" class="flex min-h-11 flex-col items-center justify-center gap-1 rounded-xl text-xs font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1V10Z"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('monitored-billers') }}" class="flex min-h-11 flex-col items-center justify-center gap-1 rounded-xl text-xs font-semibold transition {{ request()->routeIs('monitored-billers') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}" {{ request()->routeIs('monitored-billers') ? 'aria-current=page' : '' }}>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 1 4 16.5v-11ZM4 16.5A2.5 2.5 0 0 1 6.5 14H20M8 7h8m-8 3h5"></path></svg>
            Billers
        </a>
    </div>
</div>
