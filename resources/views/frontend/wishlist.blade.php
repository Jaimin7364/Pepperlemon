@extends('layouts.frontend')

@section('title', 'My Wishlist')

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
                    <span class="text-slate-800">Wishlist</span>
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
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($products as $product)
                    <div class="group border border-gray-200 bg-white rounded-xl p-3 transition-all duration-300 hover:shadow flex flex-col h-full product-wishlist-card" data-id="{{ $product->id }}">
                        <div class="w-full bg-white rounded-xl flex items-center justify-center relative overflow-hidden aspect-square border border-gray-100">
                            <!-- Product Image -->
                            <a href="/product/{{ $product->slug }}" class="w-full h-full flex items-center justify-center p-2">
                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
                            </a>
                            
                            <!-- Sale Badge -->
                            @if($product->sale_price)
                            <div class="absolute top-2 left-2 bg-red-500 text-white text-[8px] uppercase font-bold px-1.5 py-0.5 rounded z-10">Sale</div>
                            @endif
                            
                            <!-- Right Icons -->
                            <div class="flex flex-col space-y-1.5 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300 z-10" style="position: absolute; top: 8px; right: 8px; left: auto;">
                                <button class="bg-white text-red-500 p-1.5 rounded-full shadow border border-gray-100 hover:bg-gray-50 transition w-8 h-8 flex items-center justify-center text-xs btn-wishlist" data-product-id="{{ $product->id }}" title="Remove from Wishlist"><i class="fa-solid fa-heart"></i></button>
                                <button class="bg-white text-gray-800 p-1.5 rounded-full shadow border border-gray-100 hover:text-primary hover:bg-gray-50 transition w-8 h-8 flex items-center justify-center text-xs btn-quickview" data-product-slug="{{ $product->slug }}" title="Quick View"><i class="fa-regular fa-eye"></i></button>
                                <button class="bg-white text-gray-800 p-1.5 rounded-full shadow border border-gray-100 hover:text-primary hover:bg-gray-50 transition w-8 h-8 flex items-center justify-center text-xs btn-add-to-cart md:hidden" data-product-id="{{ $product->id }}" title="Add to Cart">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </div>
                            
                            <!-- Add to Cart Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-10 hidden md:block">
                                <button class="w-full bg-[#C49A6C] hover:bg-primary-dark text-white font-semibold py-2.5 tracking-wider text-xs uppercase btn-add-to-cart transition-colors duration-300 cursor-pointer" data-product-id="{{ $product->id }}">ADD TO CART</button>
                            </div>
                        </div>
                        
                        <div class="pt-3 text-left flex-1 flex flex-col justify-between">
                            <h3 class="text-xs sm:text-sm font-sans font-medium text-black leading-snug">
                                <a href="/product/{{ $product->slug }}" class="hover:text-primary transition">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            @if($product->sale_price)
                            <div class="flex items-center space-x-1.5 mt-1">
                                <p class="text-sm font-bold text-primary">${{ number_format($product->sale_price) }}</p>
                                <p class="text-[10px] font-medium text-gray-400 line-through">${{ number_format($product->price) }}</p>
                            </div>
                            @else
                            <p class="text-sm font-bold text-primary mt-1">${{ number_format($product->price) }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-[#f5faf7]/40 rounded-xl border border-dashed border-primary/20">
                    <i class="fa-regular fa-heart text-5xl text-gray-300 mb-4"></i>
                    <h2 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight mb-1" style="font-family: 'Outfit', sans-serif;">Your Wishlist is Empty</h2>
                    <p class="text-slate-500 text-xs mb-6 max-w-xs mx-auto">Add items that you like to your wishlist so you can find them easily later.</p>
                    <a href="/shop" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-2.5 rounded-lg text-xs tracking-wider transition">
                        BROWSE PRODUCTS
                    </a>
                </div>
            @endif
        </div>

        @auth
        </div>
        </div>
        @endauth
    </div>
@endsection
