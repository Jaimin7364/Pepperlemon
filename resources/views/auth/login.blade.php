@extends('layouts.frontend')

@section('title', 'Log In')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4 bg-[#f5faf7]/40">
        <div class="max-w-md w-full bg-white border border-gray-100 p-8 sm:p-10 rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-serif font-bold text-gray-900" style="font-family: 'Outfit', sans-serif;">Welcome Back</h2>
                <p class="text-sm text-gray-500 mt-2 font-sans">Log in to manage your orders and account.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-sm font-semibold text-green-700 bg-green-50 border border-green-200 px-4 py-3 rounded-lg" :status="session('status')" />


            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Google Login Button -->
                <div class="mb-6">
                    <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3 rounded-xl transition duration-200 shadow-sm cursor-pointer">
                        <svg class="w-5 h-5" viewBox="0 0 48 48">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                            <path fill="none" d="M0 0h48v48H0z"></path>
                        </svg>
                        Continue with Google
                    </a>
                </div>

                <div class="relative flex items-center justify-center mb-6">
                    <span class="absolute inset-x-0 h-px bg-gray-200"></span>
                    <span class="relative bg-white px-4 text-xs text-gray-400 font-semibold uppercase tracking-wider">Or</span>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Password -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" class="w-full bg-white border border-gray-200 rounded-xl pl-4 pr-10 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                            <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4">
                        <span class="ms-2 text-xs text-gray-500">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs text-primary hover:text-primary-dark font-semibold underline" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3.5 rounded-xl tracking-wider text-sm transition-all duration-300 shadow-md uppercase cursor-pointer hover:shadow-lg transform hover:-translate-y-0.5">
                        Log In
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center text-sm">
                <span class="text-gray-500">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-primary hover:text-primary-dark font-bold ml-1 hover:underline">Register here</a>
            </div>
        </div>
    </div>
@endsection
