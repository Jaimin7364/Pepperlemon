@extends('layouts.frontend')

@section('title', 'Forgot Password')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4 bg-[#FAF6F0]/30">
        <div class="max-w-md w-full bg-[#FAF6F0] border border-[#C49A6C]/50 p-8 sm:p-10 rounded-2xl shadow-xl">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-serif font-bold text-gray-900">Reset Password</h2>
                <p class="text-xs text-gray-500 mt-2 font-sans leading-relaxed">
                    Forgot your password? No problem. Enter your email address and we will email you a password reset link to choose a new one.
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-sm font-semibold text-green-700 bg-green-50 border border-green-200 px-4 py-3 rounded-lg" :status="session('status')" />


            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg tracking-wider text-xs shadow transition-colors uppercase" style="background-color: #C49A6C; color: white;">
                        Email Password Reset Link
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-250 text-center text-sm">
                <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark font-bold hover:underline">Back to Log In</a>
            </div>
        </div>
    </div>
@endsection
