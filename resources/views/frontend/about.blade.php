@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">About Us</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">About Us</h1>
        </div>
    </div>

    <!-- About Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-16" x-data="{ activeTab: 'about' }">
        
        <!-- Tabs -->
        <div class="flex border-b border-gray-200 mb-8 sm:mb-10 overflow-x-auto justify-start md:justify-center whitespace-nowrap scrollbar-none gap-2 px-2 pb-0.5">
            <button @click="activeTab = 'about'" :class="activeTab === 'about' ? 'text-primary border-primary' : 'text-gray-500 hover:text-gray-900 border-transparent'" class="flex-shrink-0 px-6 sm:px-8 py-3 font-bold border-b-2 transition font-serif focus:outline-none cursor-pointer">About Us</button>
            <button @click="activeTab = 'story'" :class="activeTab === 'story' ? 'text-primary border-primary' : 'text-gray-500 hover:text-gray-900 border-transparent'" class="flex-shrink-0 px-6 sm:px-8 py-3 font-bold border-b-2 transition font-serif focus:outline-none cursor-pointer">Our Story</button>
            <button @click="activeTab = 'offer'" :class="activeTab === 'offer' ? 'text-primary border-primary' : 'text-gray-500 hover:text-gray-900 border-transparent'" class="flex-shrink-0 px-6 sm:px-8 py-3 font-bold border-b-2 transition font-serif focus:outline-none cursor-pointer">What We Offer</button>
        </div>

        <!-- Tab Content Area -->
        <div class="text-center max-w-4xl mx-auto text-gray-600 mb-12 sm:mb-16 leading-relaxed min-h-[220px] px-2 sm:px-0">
            <!-- About Us Tab -->
            <div x-show="activeTab === 'about'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                <h3 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-2">Pepperlemon</h3>
                <p class="text-primary font-serif italic text-sm mb-4" style="color: #C49A6C;">“Bold Flavor. Fresh Ideas.” &bull; Premium Groceries, Beverages & Essentials</p>
                <p class="text-sm sm:text-base">Pepperlemon is a premium grocery and beverage brand committed to delivering bold flavors, handpicked fresh produce, and high-quality artisanal goods right to your doorstep. We combine fresh sourcing with modern quality standards to create an unmatched shopping experience.</p>
            </div>

            <!-- Our Story Tab -->
            <div x-show="activeTab === 'story'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <h3 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-4">Our Journey</h3>
                <p class="text-sm sm:text-base">Our journey began with a simple vision: to bring fresh, authentic, and vibrant food options to every home. We focus on quality, freshness, and environmentally responsible practices to deliver products you can trust every day.</p>
            </div>

            <!-- What We Offer Tab -->
            <div x-show="activeTab === 'offer'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <h3 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-4">What We Offer</h3>
                <p class="text-sm sm:text-base">Our range includes fresh produce, gourmet snacks, premium canned & bottled beverages, organic treats, and daily household essentials crafted for flavor and freshness.</p>
            </div>
        </div>

        <!-- Image Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-8 mb-12 sm:mb-20">
            <div class="bg-gray-50 rounded-2xl overflow-hidden h-64 sm:h-96 border border-gray-100 shadow-sm">
                <img src="{{ asset('images/hero_banner.jpg') }}" alt="Pepperlemon Collection" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col gap-4 sm:gap-8">
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 sm:p-6 h-36 sm:h-44 flex items-center justify-center shadow-sm">
                    <div class="text-center">
                        <h4 class="font-bold font-serif text-emerald-900 text-base sm:text-lg mb-1">PEPPERLEMON QUALITY ASSURED</h4>
                        <p class="text-[10px] text-emerald-700 font-sans tracking-wide uppercase">Farm Fresh & Certified</p>
                        <p class="text-xs sm:text-sm mt-2 sm:mt-3 text-gray-700 font-sans">Guaranteed <strong>100% Fresh & Authentic Products</strong></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 sm:gap-8 h-36 sm:h-44">
                    <div class="bg-orange-50 rounded-2xl overflow-hidden relative shadow-sm border border-orange-100">
                        <img src="{{ asset('images/product.png') }}" alt="Shop Online" class="w-full h-full object-cover opacity-70">
                        <div class="absolute inset-0 bg-black/10 flex items-center justify-center font-bold text-base sm:text-lg text-white font-serif tracking-wider drop-shadow-md">SHOP ONLINE</div>
                    </div>
                    <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                        <img src="{{ asset('images/modern_banner_new.png') }}" alt="Pepperlemon Store" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        <!-- Inspiration Section -->
        <div class="bg-[#FAF6F0] rounded-2xl p-8 md:p-16 flex flex-col md:flex-row gap-12 items-center border border-[#C49A6C]/30 shadow-sm">
            <div class="w-full md:w-1/2">
                <h2 class="text-3xl font-serif font-bold text-gray-950 mb-6">Bold flavor, fresh ideas,<br>and instant quality.</h2>
                <p class="text-gray-500 mb-8 text-sm font-sans leading-relaxed">
                    Connecting farm-fresh quality with modern convenience through authentic products and dependable service.
                </p>
                <!-- Accordions -->
                <div class="space-y-4" x-data="{ openSection: 'vision' }">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <button @click="openSection = openSection === 'vision' ? null : 'vision'" class="w-full px-6 py-4 text-left font-bold font-sans text-sm flex justify-between items-center transition focus:outline-none" :class="openSection === 'vision' ? 'text-primary' : 'text-gray-900 hover:text-primary'">
                            Our Vision
                            <i class="fa-solid text-[10px]" :class="openSection === 'vision' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="openSection === 'vision'" x-collapse class="px-6 pb-4 text-gray-650 text-xs font-sans leading-relaxed">
                            To become a trusted global brand for premium groceries and refreshing beverages that inspire vibrant living.
                        </div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <button @click="openSection = openSection === 'mission' ? null : 'mission'" class="w-full px-6 py-4 text-left font-bold font-sans text-sm flex justify-between items-center transition focus:outline-none" :class="openSection === 'mission' ? 'text-primary' : 'text-gray-900 hover:text-primary'">
                            Our Mission
                            <i class="fa-solid text-[10px]" :class="openSection === 'mission' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="openSection === 'mission'" x-collapse class="px-6 pb-4 text-gray-650 text-xs font-sans leading-relaxed" style="display: none;">
                            <ul class="list-disc pl-5 space-y-1.5 text-left font-sans">
                                <li>To deliver fresh, top-tier groceries and beverages.</li>
                                <li>To use ethically sourced and high-quality ingredients.</li>
                                <li>To ensure 100% customer satisfaction with fast delivery.</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <button @click="openSection = openSection === 'why' ? null : 'why'" class="w-full px-6 py-4 text-left font-bold font-sans text-sm flex justify-between items-center transition focus:outline-none" :class="openSection === 'why' ? 'text-primary' : 'text-gray-900 hover:text-primary'">
                            Why Choose Pepperlemon?
                            <i class="fa-solid text-[10px]" :class="openSection === 'why' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="openSection === 'why'" x-collapse class="px-6 pb-4 text-gray-650 text-xs font-sans leading-relaxed" style="display: none;">
                            <ul class="list-disc pl-5 space-y-1.5 text-left font-sans">
                                <li>Fresh & premium quality produce</li>
                                <li>Curated beverage and snack collection</li>
                                <li>Express doorstep delivery</li>
                                <li>Transparent pricing and hassle-free returns</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-1/2">
                <div class="bg-gradient-to-br from-[#C49A6C]/30 to-[#b0875b]/30 rounded-2xl overflow-hidden h-96 flex items-center justify-center p-8 border border-[#C49A6C]/20 shadow-inner relative group">
                    <img src="{{ asset('images/about_meditation.png') }}" alt="Meditation Corner" class="w-full h-full object-cover rounded-xl shadow-lg mix-blend-overlay opacity-90 group-hover:scale-102 transition duration-500">
                </div>
            </div>
        </div>
    </div>
@endsection

