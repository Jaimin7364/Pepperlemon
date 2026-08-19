@extends('layouts.frontend')

@section('title', 'Register')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center py-16 px-4 bg-[#f5faf7]/40">
        <div class="max-w-2xl w-full bg-white border border-gray-100 p-6 sm:p-8 rounded-2xl shadow-xl">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-serif font-bold text-gray-900" style="font-family: 'Outfit', sans-serif;">Create Account</h2>
                <p class="text-sm text-gray-500 mt-1 font-sans">Register to track orders and save your details.</p>
            </div>

            <!-- Validation Errors Banner -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-xs">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-xmark mt-0.5 text-red-500 text-sm"></i>
                        <div>
                            <span class="block text-xs font-bold text-red-900 mb-1">Please correct the following errors:</span>
                            <ul class="list-disc list-inside text-xs space-y-0.5 text-red-750">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <!-- Google Login Button -->
                <div class="mb-4">
                    <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 rounded-xl transition duration-200 shadow-sm cursor-pointer">
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

                <div class="relative flex items-center justify-center mb-4">
                    <span class="absolute inset-x-0 h-px bg-gray-200"></span>
                    <span class="relative bg-white px-4 text-xs text-gray-400 font-semibold uppercase tracking-wider">Or</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                    </div>
                </div>

                <!-- Customer Phone Number -->
                <div>
                    <label for="phone" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Customer Phone Number</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="e.g. +1 (555) 019-9150" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-xs text-red-600" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <!-- Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Password</label>
                        <div class="relative">
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" class="w-full bg-white border border-gray-200 rounded-lg pl-3 pr-10 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                                <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- Confirm Password -->
                    <div x-data="{ showConfirmPassword: false }">
                        <label for="password_confirmation" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Confirm Password</label>
                        <div class="relative">
                            <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" class="w-full bg-white border border-gray-200 rounded-lg pl-3 pr-10 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                                <i class="fa-solid text-sm" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-600" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-2.5 rounded-lg tracking-wider text-sm transition-all duration-300 shadow-sm uppercase cursor-pointer hover:shadow transform hover:-translate-y-0.5">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-4 border-t border-gray-100 text-center text-sm">
                <span class="text-gray-500">Already have an account?</span>
                <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark font-bold ml-1 hover:underline">Log in here</a>
            </div>
        </div>
    </div>
@endsection
