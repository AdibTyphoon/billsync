<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <header class="mb-8">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">BillSync settings</p>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Account &amp; Profile</h1>
                <p class="mt-2 text-sm text-slate-500">Manage your personal information and security preferences.</p>
            </header>

            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-2 lg:gap-8">

                <div class="space-y-6">
                    <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm shadow-slate-900/5 transition duration-200 hover:shadow-md sm:p-8">
                        <div class="mb-7 flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <div>
                                <h2 class="text-lg font-bold text-slate-950">Profile Information</h2>
                                <p class="mt-0.5 text-xs text-slate-500">Update the name and email associated with your account.</p>
                            </div>
                        </div>

                        <div class="mb-8 flex flex-col items-center rounded-2xl bg-slate-50 px-4 py-6">
                            <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-600 text-2xl font-bold text-white shadow-lg shadow-indigo-600/20">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <p class="mt-3 text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">Full name</label>
                                <input id="name" name="name" type="text"
                                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"
                                       value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">Email address</label>
                                <input id="email" name="email" type="email"
                                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"
                                       value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center">
                                <button type="submit" class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-600/15 transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 sm:w-auto">
                                    Save changes
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Saved.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm shadow-slate-900/5 transition duration-200 hover:shadow-md sm:p-8">
                        <div class="mb-7 flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <h2 class="text-lg font-bold text-slate-950">Security Settings</h2>
                                <p class="mt-0.5 text-xs text-slate-500">Choose a strong password to protect your account.</p>
                            </div>
                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Protected
                            </span>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">Current password</label>
                                <input id="update_password_current_password" name="current_password" type="password"
                                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                       autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="update_password_password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">New password</label>
                                <input id="update_password_password" name="password" type="password"
                                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                       autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="update_password_password_confirmation" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">Confirm new password</label>
                                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                       autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center">
                                <button type="submit" class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2 sm:w-auto">
                                    Update password
                                </button>

                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Saved.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>

                <div class="space-y-6">
                    <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm shadow-slate-900/5 transition duration-200 hover:shadow-md sm:p-8">
                        <div class="mb-6 flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </span>
                            <div>
                                <h2 class="text-lg font-bold text-slate-950">Account Overview</h2>
                                <p class="mt-0.5 text-xs text-slate-500">A quick look at your BillSync account.</p>
                            </div>
                        </div>

                        <div class="divide-y divide-slate-100">
                            <div class="flex items-center justify-between gap-4 py-4 first:pt-0">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Member since</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ Auth::user()->created_at?->format('F d, Y') ?? 'Date Not Available' }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-sky-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-sky-700 ring-1 ring-inset ring-sky-100">
                                    <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                                    Verified
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 py-4 last:pb-0">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </span>
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Account tier</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-900">Standard Tier</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-500">Standard</span>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm shadow-slate-900/5 transition duration-200 hover:shadow-md sm:p-8">
                        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </span>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-950">Two-Factor Authentication</h2>
                                    <p class="mt-0.5 text-xs text-slate-500">An additional layer for your account.</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        </div>

                        <p class="text-sm leading-6 text-slate-600">
                            Protect your account with an extra layer of security. Once configured, you'll be required to enter both your password and an authentication code from your mobile phone.
                        </p>

                        <div class="mt-5 flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="text-sm font-semibold text-emerald-800">2FA is currently active and protecting your account.</p>
                                <p class="mt-1 text-xs text-emerald-700">Configured using Authenticator App</p>
                            </div>
                        </div>
                    </section>

                    @if(session('success'))
                        <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800 shadow-sm" role="status">
                            <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-800 shadow-sm" role="alert">
                            <svg class="h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm shadow-slate-900/5 transition duration-200 hover:shadow-md sm:p-8">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.18-.08-.05-.19-.02-.27 0-.11.03-1.88 1.2-3.32 2.17-.21.14-.4.21-.57.21-.16 0-.38-.05-.62-.13-.39-.13-1.12-.34-1.52-.51-.53-.22-.76-.34-.72-.73.02-.19.14-.38.38-.59 1.5-1.01 5.03-2.48 7.08-3.32 3.37-1.39 4.07-1.63 4.52-1.64.1 0 .31.02.43.13.1.09.13.21.14.31-.01.04-.01.12-.02.25z"/></svg>
                            </span>
                            <div>
                                <h2 class="text-lg font-bold text-slate-950">Telegram Bot Notifications</h2>
                                <p class="mt-0.5 text-xs text-slate-500">Billing alerts delivered to your Telegram.</p>
                            </div>
                        </div>

                        <p class="mb-5 text-sm leading-6 text-slate-600">Receive billing notifications directly in your Telegram app.</p>

                        @if(Auth::user()->telegram_chat_id)
                            <div class="space-y-4">
                                <div class="flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-800">Telegram Connected</p>
                                        <p class="mt-1 text-xs text-emerald-700">Notifications are ready for this account.</p>
                                    </div>
                                </div>

                                <a href="{{ url('/telegram/test') }}" class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-sky-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.18-.08-.05-.19-.02-.27 0-.11.03-1.88 1.2-3.32 2.17-.21.14-.4.21-.57.21-.16 0-.38-.05-.62-.13-.39-.13-1.12-.34-1.52-.51-.53-.22-.76-.34-.72-.73.02-.19.14-.38.38-.59 1.5-1.01 5.03-2.48 7.08-3.32 3.37-1.39 4.07-1.63 4.52-1.64.1 0 .31.02.43.13.1.09.13.21.14.31-.01.04-.01.12-.02.25z"/></svg>
                                    Send test message
                                </a>
                            </div>
                        @else
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-800">Connect your Telegram account</p>
                                <p class="mt-1 text-xs leading-5 text-slate-500">Start the BillSync bot, then verify the connection here to enable billing notifications.</p>
                            </div>

                            <div class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-2">
                                <a href="https://t.me/BillSyncBot?start={{ Auth::user()->id }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-sky-500 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-sky-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2">
                                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-white/20 text-xs font-bold">1</span>
                                    Open bot &amp; click Start
                                </a>
                                <a href="{{ url('/telegram/sync') }}"
                                   class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2">
                                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-white/15 text-xs font-bold">2</span>
                                    Verify connection
                                </a>
                            </div>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>