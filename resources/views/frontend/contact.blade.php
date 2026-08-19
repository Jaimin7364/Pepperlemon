@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <!-- Breadcrumb & Title Inline -->
        <div class="mb-1 flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 border-b border-slate-100">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight" style="font-family: 'Outfit', sans-serif;">My Account</h1>
                <p class="text-[10px] text-slate-450 mt-1 flex items-center gap-1.5 font-bold uppercase tracking-wider">
                    <a href="/" class="hover:text-primary transition-colors">Home</a> 
                    <span class="text-slate-300">/</span> 
                    @auth
                        <a href="/dashboard" class="hover:text-primary transition-colors">Dashboard</a> 
                        <span class="text-slate-300">/</span> 
                    @endauth
                    <span class="text-slate-800">Support & Help</span>
                </p>
            </div>
        </div>

        @auth
        <div class="flex flex-col lg:flex-row gap-4">
            @include('frontend.partials.customer_sidebar')
            
            <div class="w-full lg:w-3/4">
        @else
            <div class="w-full">
        @endauth

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-7">
                <!-- Contact Info -->
                <div class="flex flex-col justify-between h-full space-y-4">
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-1.5" style="font-family: 'Outfit', sans-serif;">{{ __('Get In Touch') }}</h2>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed mb-4">
                            {{ __("We'd love to hear from you. Whether you have a question about products, shipping, or need product recommendations, our team is ready to answer all your questions.") }}
                        </p>
                        
                        <div class="space-y-3">
                            <div class="flex items-start bg-slate-50 border border-slate-100 p-3 rounded-xl hover:border-slate-200 transition duration-150">
                                <div class="bg-primary/10 text-primary p-2.5 rounded-lg mr-3 flex-shrink-0">
                                    <i class="fa-solid fa-location-dot text-sm w-4 text-center"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-extrabold text-slate-800 text-[10px] uppercase tracking-wider">{{ __('Address') }}</h4>
                                    <p class="text-xs text-slate-900 font-bold mt-0.5 leading-normal">
                                        {{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start bg-slate-50 border border-slate-100 p-3 rounded-xl hover:border-slate-200 transition duration-150">
                                <div class="bg-primary/10 text-primary p-2.5 rounded-lg mr-3 flex-shrink-0">
                                    <i class="fa-solid fa-phone text-sm w-4 text-center"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-extrabold text-slate-800 text-[10px] uppercase tracking-wider">{{ __('Phone Number') }}</h4>
                                    <p class="text-xs text-slate-900 font-bold mt-0.5 leading-normal">
                                        {{ \App\Models\Setting::get('site_phone', '+1 (713) 555-0199') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start bg-slate-50 border border-slate-100 p-3 rounded-xl hover:border-slate-200 transition duration-150">
                                <div class="bg-primary/10 text-primary p-2.5 rounded-lg mr-3 flex-shrink-0">
                                    <i class="fa-solid fa-envelope text-sm w-4 text-center"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-extrabold text-slate-800 text-[10px] uppercase tracking-wider">{{ __('Email Address') }}</h4>
                                    <p class="text-xs text-slate-900 font-bold mt-0.5 leading-normal">
                                        {{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @php
                            $facebook = \App\Models\Setting::get('social_facebook');
                            $twitter = \App\Models\Setting::get('social_twitter');
                            $instagram = \App\Models\Setting::get('social_instagram');
                            $linkedin = \App\Models\Setting::get('social_linkedin');
                            $youtube = \App\Models\Setting::get('social_youtube');
                            $hasSocial = $facebook || $twitter || $instagram || $linkedin || $youtube;
                        @endphp
                        @if($hasSocial)
                            <div class="mt-5 border-t border-slate-100 pt-4">
                                <h4 class="font-extrabold text-slate-800 text-[10px] uppercase tracking-wider mb-2.5">{{ __('Connect With Us') }}</h4>
                                <div class="flex items-center gap-2">
                                    @if($facebook)
                                        <a href="{{ $facebook }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-primary hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-2xs" title="Facebook"><i class="bi bi-facebook"></i></a>
                                    @endif
                                    @if($twitter)
                                        <a href="{{ $twitter }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-primary hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-2xs" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                                    @endif
                                    @if($instagram)
                                        <a href="{{ $instagram }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-primary hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-2xs" title="Instagram"><i class="bi bi-instagram"></i></a>
                                    @endif
                                    @if($linkedin)
                                        <a href="{{ $linkedin }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-primary hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-2xs" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                                    @endif
                                    @if($youtube)
                                        <a href="{{ $youtube }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-primary hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-2xs" title="YouTube"><i class="bi bi-youtube"></i></a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-xl border border-slate-150 p-4 sm:p-4.5 shadow-xs">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-3.5 border-b border-slate-100 pb-2.5" style="font-family: 'Outfit', sans-serif;">{{ __('Send us a message') }}</h3>
                    <form action="#" method="POST" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">{{ __('First Name *') }}</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                                        <i class="fa-solid fa-user text-xs"></i>
                                    </span>
                                    <input type="text" class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 shadow-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">{{ __('Last Name *') }}</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                                        <i class="fa-solid fa-user text-xs"></i>
                                    </span>
                                    <input type="text" class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 shadow-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" required>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">{{ __('Email Address *') }}</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-envelope text-xs"></i>
                                </span>
                                <input type="email" class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 shadow-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">{{ __('Message *') }}</label>
                            <div class="relative">
                                <span class="absolute top-2.5 left-0 pl-3 flex items-start text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </span>
                                <textarea rows="3" class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 shadow-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" required></textarea>
                            </div>
                        </div>
                        
                        <div class="pt-1">
                            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-extrabold py-2 rounded-xl tracking-wider text-[11px] transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 cursor-pointer flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-paper-plane text-[10px]"></i> {{ __('Send Message') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div></div>
        </div>

        @auth
        </div>
        </div>
        @endauth
    </div>
@endsection
