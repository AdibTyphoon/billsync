<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BillSync</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans antialiased py-8">
    
    <div class="flex flex-col md:flex-row-reverse bg-white rounded-[2rem] shadow-2xl overflow-hidden max-w-5xl w-full mx-4 sm:mx-8">
        
        <!-- Panel Kanan: Fintech Branding (Diterbalikkan kedudukan untuk variasi) -->
        <div class="md:w-1/2 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white p-12 flex flex-col justify-center relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center space-x-2 mb-8">
                    <!-- Logo Placeholder -->
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-blue-900 font-bold text-xl">B</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight">BillSync</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-black mb-6 leading-tight">Take Control of Your Expenses.</h1>
                <p class="text-blue-200 text-sm lg:text-base font-medium">Join us to automate your utility trackers and never miss a due date again.</p>
            </div>
            
            <!-- Corak Latar Belakang Abstrak -->
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-blue-500 opacity-20 rounded-full blur-2xl"></div>
        </div>

        <!-- Panel Kiri: Borang Pendaftaran -->
        <div class="md:w-1/2 p-10 lg:p-14 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Create an Account</h2>
            <p class="text-gray-500 text-sm mb-8">Sign up to start managing your bills effortlessly.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                        class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all text-sm outline-none shadow-sm placeholder-gray-400"
                        placeholder="Muhammad Adib">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all text-sm outline-none shadow-sm placeholder-gray-400"
                        placeholder="adib@billsync.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                        class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all text-sm outline-none shadow-sm placeholder-gray-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                        class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all text-sm outline-none shadow-sm placeholder-gray-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-[0_8px_20px_-6px_rgba(37,99,235,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <p class="mt-8 text-center text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition duration-200">
                    Sign in
                </a>
            </p>
        </div>
    </div>
    
</body>
</html>