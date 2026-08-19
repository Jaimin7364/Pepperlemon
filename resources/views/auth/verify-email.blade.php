@extends('layouts.frontend')

@section('title', 'Verify Email')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4 bg-[#FAF6F0]/30">
        <div class="max-w-md w-full bg-[#FAF6F0] border border-[#C49A6C]/50 p-8 sm:p-10 rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-serif font-bold text-gray-900">Verify Email</h2>
                <p class="text-sm text-gray-500 mt-2 font-sans">Please confirm your email address to continue.</p>
            </div>

            <div class="mb-6 text-sm text-gray-600 leading-relaxed">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 text-sm font-semibold text-green-700 bg-green-50 border border-green-200 px-4 py-3 rounded-lg">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <x-primary-button class="w-full justify-center">
                        {{ __('Resend Email') }}
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600 underline font-medium font-sans">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
