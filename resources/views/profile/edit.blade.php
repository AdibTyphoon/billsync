<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Account & Profile</h2>
                <p class="text-gray-500 mt-1">Manage your personal information and security preferences.</p>
            </div>

            <!-- Profile Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- KIRI: Profile Info & Update Password -->
                <div class="space-y-8">
                    
                    <!-- Profile Information Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                        <div class="flex items-center mb-6">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <h3 class="text-lg font-bold text-gray-900">Profile Information</h3>
                        </div>

                        <!-- Avatar (Visual Only) -->
                        <div class="flex flex-col items-center mb-8">
                            <div class="w-24 h-24 rounded-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg mb-3">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <button class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">+ Change Avatar</button>
                        </div>

                        <!-- Borang Kemaskini Profil Berfungsi -->
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}"></form>
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Full Name</label>
                                <input id="name" name="name" type="text" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                                <input id="email" name="email" type="email" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit" class="w-full bg-indigo-900 hover:bg-indigo-800 text-white font-bold py-3 px-4 rounded-xl shadow-md transition duration-200">
                                    Save Changes
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 font-bold">Saved.</p>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Security Settings (Update Password) Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                        <div class="flex items-center mb-6">
                            <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <h3 class="text-lg font-bold text-gray-900">Security Settings</h3>
                            <span class="ml-auto bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wide">Protected</span>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Current Password</label>
                                <input id="update_password_current_password" name="current_password" type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="update_password_password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">New Password</label>
                                <input id="update_password_password" name="password" type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="update_password_password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Confirm New Password</label>
                                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-4 rounded-xl shadow-md transition duration-200">
                                    Update Password
                                </button>

                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 font-bold">Saved.</p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- KANAN: Account Overview & 2FA -->
                <div class="space-y-8">
                    
                    <!-- Account Overview Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                        <div class="flex items-center mb-6">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <h3 class="text-lg font-bold text-gray-900">Account Overview</h3>
                        </div>

                        <div class="space-y-6">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Member Since</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->created_at?->format('F d, Y') ?? 'Date Not Available' }}</p>                                    </div>
                                </div>
                                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">Verified</span>
                            </div>

                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Account Tier</p>
                                        <p class="text-sm font-semibold text-gray-900">Standard Tier</p>
                                    </div>
                                </div>
                                <button class="text-xs font-bold text-gray-400 hover:text-gray-900 transition">Upgrade</button>
                            </div>
                        </div>
                    </div>

                    <!-- Two-Factor Authentication (2FA) Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <h3 class="text-lg font-bold text-gray-900">Two-Factor Authentication</h3>
                            </div>
                            <!-- Fake Toggle UI -->
                            <div class="w-11 h-6 bg-emerald-500 rounded-full relative cursor-pointer shadow-inner">
                                <div class="w-5 h-5 bg-white rounded-full absolute right-0.5 top-0.5 shadow-sm"></div>
                            </div>
                        </div>

                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Protect your account with an extra layer of security. Once configured, you'll be required to enter both your password and an authentication code from your mobile phone.
                        </p>

                        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 flex items-start">
                            <svg class="w-5 h-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="text-sm font-bold text-emerald-800">2FA is currently active and protecting your account.</p>
                                <p class="text-xs text-emerald-600 mt-1">Configured using Authenticator App</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>