<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BillSync</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans antialiased">
    
    <div class="flex flex-col md:flex-row bg-white rounded-[2rem] shadow-2xl overflow-hidden max-w-5xl w-full mx-4 sm:mx-8">
        
        <!-- Panel Kiri: Fintech Branding -->
        <div class="md:w-1/2 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white p-12 flex flex-col justify-center relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center space-x-2 mb-8">
                    <!-- Logo Placeholder -->
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-blue-900 font-bold text-xl">B</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight">BillSync</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-black mb-6 leading-tight">Manage All Your Bills in One Place.</h1>
                <p class="text-blue-200 text-sm lg:text-base font-medium">A smart centralized utility and subscription management platform.</p>
            </div>
            
            <!-- Corak Latar Belakang Abstrak -->
            <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute -top-12 -left-12 w-48 h-48 bg-blue-500 opacity-20 rounded-full blur-2xl"></div>
        </div>

        <!-- Panel Kanan: Borang Log Masuk -->
        <div class="md:w-1/2 p-10 lg:p-16 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
            <p class="text-gray-500 text-sm mb-10">Please enter your details to sign in to your dashboard.</p>

            <!-- Paparan Ralat -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all text-sm outline-none shadow-sm placeholder-gray-400"
                        placeholder="adib@gmail.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                        class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all text-sm outline-none shadow-sm placeholder-gray-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-10">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 transition duration-200">
                        <span class="ml-2 text-sm font-medium text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm font-bold text-blue-600 hover:text-blue-800 transition duration-200" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-[0_8px_20px_-6px_rgba(37,99,235,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                    Sign In
                </button>
            </form>

                 <!-- Register Link -->
                    <p class="mt-8 text-center text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 transition duration-200">
                        Sign up
                        </a>
                    </p>
                </div>
            </div>
        </div>      
    
</body>
</html>