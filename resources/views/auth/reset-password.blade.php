@extends('layouts.frontend')

@section('title', 'Reset Password')

@section('content')
    <div class="min-h-[75vh] flex items-center justify-center py-16 px-4 bg-[#FAF6F0]/30">
        <div class="max-w-md w-full bg-[#FAF6F0] border border-[#C49A6C]/50 p-8 sm:p-10 rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-serif font-bold text-gray-900">Choose New Password</h2>
                <p class="text-sm text-gray-500 mt-2 font-sans">Set a secure password for your account.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Password -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">New Password</label>
                    <div class="relative">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" class="w-full bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                            <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Confirm Password -->
                <div x-data="{ showConfirmPassword: false }">
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Confirm Password</label>
                    <div class="relative">
                        <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" class="w-full bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                            <i class="fa-solid text-sm" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg tracking-wider text-sm transition shadow-md uppercase" style="background-color: #C49A6C; color: white;">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
