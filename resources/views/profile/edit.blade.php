@extends('layouts.frontend')

@section('title', 'Edit Profile')

@section('content')
    <!-- Profile Editing Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <!-- Breadcrumb & Title Inline -->
        <div class="mb-1 flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 border-b border-slate-100">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight" style="font-family: 'Outfit', sans-serif;">My Account</h1>
                <p class="text-[10px] text-slate-450 mt-1 flex items-center gap-1.5 font-bold uppercase tracking-wider">
                    <a href="/" class="hover:text-primary transition-colors">Home</a> 
                    <span class="text-slate-300">/</span> 
                    <a href="/dashboard" class="hover:text-primary transition-colors">Dashboard</a> 
                    <span class="text-slate-300">/</span> 
                    <span class="text-slate-800">Profile</span>
                </p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-4">
            
            @include('frontend.partials.customer_sidebar')

            <!-- Content Area: Forms -->
            <div class="w-full lg:w-3/4 space-y-3.5">
                <!-- Update Profile Info Form -->
                <div class="p-4 sm:p-5 bg-white border border-slate-150 rounded-xl shadow-xs">
                    <div class="max-w-3xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Form -->
                <div class="p-4 sm:p-5 bg-white border border-slate-150 rounded-xl shadow-xs">
                    <div class="max-w-3xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User Form -->
                <div class="p-4 sm:p-5 bg-white border border-slate-150 rounded-xl shadow-xs">
                    <div class="max-w-3xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
