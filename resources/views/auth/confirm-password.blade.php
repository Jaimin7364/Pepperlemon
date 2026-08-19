@extends('layouts.frontend')

@section('title', 'Confirm Password')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4 bg-[#FAF6F0]/30">
        <div class="max-w-md w-full bg-[#FAF6F0] border border-[#C49A6C]/50 p-8 sm:p-10 rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-serif font-bold text-gray-900">Confirm Password</h2>
                <p class="text-sm text-gray-500 mt-2 font-sans">This is a secure area of the application.</p>
            </div>

            <div class="mb-6 text-sm text-gray-600 leading-relaxed">
                {{ __('Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                </div>

                <div>
                    <x-primary-button class="w-full">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
