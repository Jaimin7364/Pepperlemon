@extends('layouts.frontend')

@section('title', 'My Cart')

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
                    <span class="text-slate-800">Cart</span>
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

            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Cart list -->
                <div class="w-full {{ empty($cart) ? 'w-full' : 'lg:w-[65%]' }}">
                    @if(empty($cart))
                        <div class="text-center py-16 bg-[#f5faf7]/40 rounded-xl border border-dashed border-primary/20">
                            <i class="fa-solid fa-cart-shopping text-5xl text-gray-300 mb-4"></i>
                            <h2 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight mb-1" style="font-family: 'Outfit', sans-serif;">Your Cart is Empty</h2>
                            <p class="text-slate-500 text-xs mb-6 max-w-xs mx-auto">Browse our shop to add premium grocery and daily essential items to your cart.</p>
                            <a href="/shop" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-2.5 rounded-lg text-xs tracking-wider transition">
                                Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="bg-white border border-slate-150 rounded-2xl p-4 shadow-sm divide-y divide-slate-100">
                            @foreach($cart as $id => $item)
                                @php
                                    $liveProduct = \App\Models\Product::find($id);
                                    $itemName = $liveProduct ? $liveProduct->name : $item['name'];
                                    $itemPrice = $liveProduct ? ($liveProduct->sale_price ?? $liveProduct->price) : $item['price'];
                                    $itemImage = $liveProduct ? $liveProduct->primary_image_url : $item['image'];
                                @endphp
                                <div class="py-3.5 flex gap-3.5 {{ $loop->first ? 'pt-0' : '' }} {{ $loop->last ? 'pb-0' : '' }}">
                                    <!-- Image Container -->
                                    <div class="w-16 h-16 bg-[#f5faf7] border border-slate-100 rounded-xl p-1 flex items-center justify-center flex-shrink-0 shadow-xs">
                                        <img src="{{ $itemImage }}" alt="{{ $itemName }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 min-w-0 flex flex-col justify-between">
                                        <!-- Title and Price Row -->
                                        <div class="flex items-start justify-between gap-2">
                                            <h4 class="font-bold text-slate-800 text-xs sm:text-sm truncate leading-tight">{{ $itemName }}</h4>
                                            <span class="font-extrabold text-slate-900 text-xs sm:text-sm whitespace-nowrap">${{ number_format($itemPrice * $item['quantity'], 2) }}</span>
                                        </div>
                                        
                                        <p class="text-[10px] text-slate-400 font-semibold mt-0.5">${{ number_format($itemPrice, 2) }} each</p>
                                        
                                        <!-- Stepper and Actions Row -->
                                        <div class="flex flex-wrap items-center justify-between gap-3 mt-2.5">
                                            <!-- Stepper -->
                                            <div class="flex items-center bg-slate-50 border border-slate-200/80 rounded-lg h-7.5 overflow-hidden">
                                                <button type="button" class="w-7.5 h-full text-slate-500 hover:bg-slate-100 text-xs flex items-center justify-center font-extrabold transition-colors cursor-pointer" onclick="updateCartQty('{{ $id }}', {{ $item['quantity'] - 1 }})">
                                                    <i class="fa-solid fa-minus text-[9px]"></i>
                                                </button>
                                                <span class="w-8 text-center text-xs font-extrabold text-slate-800">{{ $item['quantity'] }}</span>
                                                <button type="button" class="w-7.5 h-full text-slate-500 hover:bg-slate-100 text-xs flex items-center justify-center font-extrabold transition-colors cursor-pointer" onclick="updateCartQty('{{ $id }}', {{ $item['quantity'] + 1 }})">
                                                    <i class="fa-solid fa-plus text-[9px]"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Remove button -->
                                            <button type="button" class="text-[10px] text-red-500 hover:text-red-700 font-bold flex items-center gap-1 cursor-pointer transition-colors" onclick="removeCartItem('{{ $id }}')">
                                                <i class="fa-solid fa-trash-can text-[9px]"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Order summary -->
                @if(!empty($cart))
                    @php 
                        $subtotal = array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart));
                        $delivery = 0; // Free delivery matching checkout config
                        $total = $subtotal;
                    @endphp
                    <div class="w-full lg:w-[35%]">
                        <div class="bg-white border border-slate-150 rounded-2xl p-4 shadow-sm sticky top-24">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 border-b border-slate-100 pb-2.5" style="font-family: 'Outfit', sans-serif;">Order Summary</h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-slate-500 text-xs">
                                    <span class="font-medium">Subtotal</span>
                                    <span class="font-extrabold text-slate-800 font-sans">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-slate-500 text-xs">
                                    <span class="font-medium">Shipping</span>
                                    <span class="text-green-600 font-extrabold uppercase text-[9px] tracking-wider">Free</span>
                                </div>
                                <hr class="border-slate-100">
                                <div class="flex justify-between text-xs font-bold text-slate-900 pt-1">
                                    <span>Total Amount</span>
                                    <span class="text-slate-900 font-extrabold">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-2.5 rounded-xl tracking-wider text-[11px] transition-all duration-300 shadow-md cursor-pointer hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-1">
                                Proceed to Checkout <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        @auth
        </div>
        </div>
        @endauth
    </div>

    <!-- Scripting for cart dynamics -->
    <script>
        function updateCartQty(productId, qty) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId, quantity: qty })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error updating cart.');
                }
            })
            .catch(err => console.error(err));
        }

        function removeCartItem(productId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (confirm('Are you sure you want to remove this item?')) {
                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error removing item.');
                    }
                })
                .catch(err => console.error(err));
            }
        }
    </script>
@endsection
