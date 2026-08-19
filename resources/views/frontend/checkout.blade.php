@extends('layouts.frontend')

@section('title', 'Checkout')

@section('content')
    @php
        $address1 = '';
        $address2 = '';
        if (auth()->check() && auth()->user()->address) {
            $parts = explode("\n", auth()->user()->address, 2);
            $address1 = $parts[0] ?? '';
            $address2 = $parts[1] ?? '';
            
            if (empty($address2) && str_contains($address1, ',')) {
                $parts = explode(',', $address1, 2);
                $address1 = trim($parts[0]);
                $address2 = trim($parts[1]);
            }
        }
    @endphp
    <!-- Flash Messages (cancel/error/warning) -->
    @if(session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3">
            <div class="flex items-start gap-2 bg-amber-50 border border-amber-200 text-amber-800 rounded-lg px-3 py-2 text-xs font-medium shadow-sm">
                <i class="fa-solid fa-triangle-exclamation mt-0.5 text-amber-500"></i>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3">
            <div class="flex items-start gap-2 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg px-3 py-2 text-xs font-medium shadow-sm">
                <i class="fa-solid fa-circle-xmark mt-0.5 text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Checkout Form -->
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-4 md:py-6">
        <!-- Breadcrumb & Title Inline -->
        <div class="mb-4 flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-2">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight" style="font-family: 'Outfit', sans-serif;">Checkout</h1>
                <p class="text-[10px] md:text-[11px] text-gray-400 mt-0.5">
                    <a href="/" class="hover:text-primary transition">Home</a> / 
                    <span class="text-gray-900 font-medium">Checkout</span>
                </p>
            </div>
            @guest
                <span class="text-[9px] text-primary font-bold bg-primary/10 px-2 py-0.5 rounded uppercase tracking-wider">Guest Checkout</span>
            @endguest
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded mb-4">
                <ul class="list-disc list-inside text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @guest
            <div class="mb-4 p-3 bg-primary/5 border border-primary/10 rounded-xl flex items-center gap-3 shadow-sm">
                <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                    <i class="fa-regular fa-user text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-600">Checking out as guest. Already have an account? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Log in here</a>.</p>
                </div>
            </div>
        @endguest

        @php
            $defaultAddress = auth()->check() ? auth()->user()->addresses()->where('is_default', true)->first() : null;
            $defaultAddressId = $defaultAddress ? $defaultAddress->id : 'new';
        @endphp
        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" x-data="{ deliveryType: 'online_delivery', selectedAddressId: '{{ $defaultAddressId }}' }">
            @csrf

            <div class="flex flex-col lg:flex-row gap-5 lg:gap-8">
                <!-- Shipping details form -->
                <div class="w-full lg:w-2/3">
                    <h2 class="text-base font-bold text-gray-900 mb-3 pb-1.5 border-b border-gray-100 flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
                        <span class="inline-block w-1 h-4 bg-primary rounded-full"></span>
                        Delivery Options
                    </h2>

                    <!-- Delivery Type Options -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-primary/5 transition shadow-sm relative"
                               :class="deliveryType === 'online_delivery' ? 'border-primary bg-primary/5' : 'border-gray-200 bg-white'">
                            <input type="radio" name="delivery_type" value="online_delivery" x-model="deliveryType" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 cursor-pointer">
                            <div class="ml-2.5">
                                <span class="font-bold text-gray-900 text-xs block">Online Delivery</span>
                                <span class="text-[10px] text-gray-400">Shipped directly to your address</span>
                            </div>
                            <div class="ms-auto text-primary opacity-60">
                                <i class="fa-solid fa-truck-fast text-base"></i>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-primary/5 transition shadow-sm relative"
                               :class="deliveryType === 'self_pickup' ? 'border-primary bg-primary/5' : 'border-gray-200 bg-white'">
                            <input type="radio" name="delivery_type" value="self_pickup" x-model="deliveryType" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 cursor-pointer">
                            <div class="ml-2.5">
                                <span class="font-bold text-gray-900 text-xs block">Self Pickup</span>
                                <span class="text-[10px] text-gray-400">Pick up from our warehouse</span>
                            </div>
                            <div class="ms-auto text-primary opacity-60">
                                <i class="fa-solid fa-house-chimney text-base"></i>
                            </div>
                        </label>
                    </div>

                    <h2 class="text-base font-bold text-gray-900 mb-3 pb-1.5 border-b border-gray-100 flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
                        <span class="inline-block w-1 h-4 bg-primary rounded-full"></span>
                        Customer & Contact Info
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-2.5">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->check() ? auth()->user()->name : '') }}" required class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->check() ? auth()->user()->email : '') }}" required class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-2.5">
                        <div class="mb-2.5">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->check() ? auth()->user()->phone : '') }}" required class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" placeholder="+1 (555) 000-0000">
                        </div>
                        <div x-show="deliveryType === 'online_delivery'">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">ZIP / Postal Code <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_zip" value="{{ old('shipping_zip', auth()->check() ? auth()->user()->zip : '') }}" :required="deliveryType === 'online_delivery'" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                        </div>
                    </div>

                    <!-- Warehouse Address details if self pickup is active -->
                    <div x-show="deliveryType === 'self_pickup'" class="mb-4 p-4 bg-amber-50/60 border border-amber-200 rounded-xl space-y-2 text-xs text-amber-900">
                        <div class="font-bold flex items-center gap-1.5 text-amber-950">
                            <i class="fa-solid fa-location-dot text-amber-700"></i> Pickup Warehouse Address
                        </div>
                        <p class="font-medium text-slate-700 leading-relaxed">
                            <strong>Pickup Address:</strong> {{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}<br>
                            <strong>Phone Support:</strong> {{ \App\Models\Setting::get('site_phone', '+1 (713) 555-0199') }}<br>
                            <strong>Email:</strong> {{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}
                        </p>
                        <p class="text-[10px] text-slate-500 italic mt-1">Please bring your order ID and invoice when picking up your products.</p>
                    </div>

                    <!-- Shipping details if delivery is active -->
                    <div x-show="deliveryType === 'online_delivery'" class="space-y-2.5">
                        @auth
                            @php
                                $userAddresses = auth()->user()->addresses;
                            @endphp
                            @if($userAddresses->isNotEmpty())
                                <div class="mb-4 bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Choose Saved Address</label>
                                    <div class="space-y-2 max-h-48 overflow-y-auto">
                                        @foreach($userAddresses as $addr)
                                            <label class="flex items-start p-2.5 border {{ $addr->is_default ? 'border-primary bg-primary/2.5' : 'border-slate-200 bg-white' }} rounded-xl cursor-pointer hover:border-primary/45 transition">
                                                <input type="radio" name="selected_address_id" value="{{ $addr->id }}" {{ $addr->is_default ? 'checked' : '' }}
                                                       @click="selectedAddressId = '{{ $addr->id }}';"
                                                       class="mt-0.5 h-3.5 w-3.5 text-primary border-gray-300">
                                                <div class="ml-2">
                                                    <p class="text-xs font-bold text-slate-800">{{ $addr->address }}@if($addr->address2), {{ $addr->address2 }}@endif</p>
                                                    <p class="text-[10px] text-slate-500 font-semibold">{{ $addr->city }}, {{ $addr->state }} - {{ $addr->zip }} | Phone: {{ $addr->phone }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                        
                                        <label class="flex items-start p-2.5 border border-slate-200 bg-white rounded-xl cursor-pointer hover:border-primary/45 transition">
                                            <input type="radio" name="selected_address_id" value="new" {{ !$defaultAddress ? 'checked' : '' }}
                                                   @click="selectedAddressId = 'new';"
                                                   class="mt-0.5 h-3.5 w-3.5 text-primary border-gray-300">
                                            <div class="ml-2">
                                                <p class="text-xs font-bold text-slate-800">Add New Address</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        <div x-show="selectedAddressId === 'new'" class="space-y-2.5">
                            <div class="mb-2.5">
                                <div class="flex justify-between items-center mb-1">
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Flat / House No. / Building <span class="text-red-500">*</span></label>
                                    <button type="button" id="detect-location-btn" class="text-[9px] text-primary bg-primary/5 hover:bg-primary/10 border border-primary/10 rounded-full px-2 py-0.5 font-semibold flex items-center gap-1 cursor-pointer transition">
                                        <i class="fa-solid fa-location-crosshairs"></i> Auto-Detect
                                    </button>
                                </div>
                                <input type="text" name="shipping_address" value="{{ old('shipping_address', $address1) }}" :required="deliveryType === 'online_delivery' && selectedAddressId === 'new'" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" placeholder="e.g. 1234 Main St, Apt 5B">
                            </div>

                            <div class="mb-2.5">
                                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Area / Colony / Street / Landmark</label>
                                <input type="text" name="shipping_address2" value="{{ old('shipping_address2', $address2) }}" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" placeholder="e.g. Sector 12, near Kali Temple, Dwarka">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-2.5">
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="shipping_city" value="{{ old('shipping_city', auth()->check() ? auth()->user()->city : '') }}" :required="deliveryType === 'online_delivery' && selectedAddressId === 'new'" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">State / Zip <span class="text-red-500">*</span></label>
                                    <div class="grid grid-cols-2 gap-1.5">
                                        <input type="text" name="shipping_state" value="{{ old('shipping_state', auth()->check() ? auth()->user()->state : '') }}" :required="deliveryType === 'online_delivery' && selectedAddressId === 'new'" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200 uppercase" placeholder="TX">
                                        <input type="text" name="shipping_zip" value="{{ old('shipping_zip', auth()->check() ? auth()->user()->zip : '') }}" :required="deliveryType === 'online_delivery' && selectedAddressId === 'new'" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" placeholder="77067">
                                    </div>
                                </div>
                            </div>

                            @auth
                                <!-- Document Uploads at add address time -->
                                <div class="bg-slate-50 p-3.5 border border-slate-100 rounded-xl space-y-2.5 mt-2">
                                    <h4 class="font-extrabold text-slate-800 text-[9px] uppercase tracking-wider pb-1.5 border-b border-slate-200/75 flex items-center gap-1">
                                        <i class="fa-solid fa-shield-halved text-primary"></i> Verification Documents
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="space-y-1">
                                            <label class="block text-[9px] font-bold text-gray-500 uppercase tracking-wider">Driving License *</label>
                                            <div class="relative flex flex-col items-center justify-center border border-dashed border-gray-300 rounded-xl bg-white p-3 hover:bg-gray-50/50 transition cursor-pointer">
                                                <input type="file" name="driving_license" :required="deliveryType === 'online_delivery' && selectedAddressId === 'new'" accept=".pdf,.jpg,.jpeg,.png"
                                                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                                                       onchange="document.getElementById('checkout-dl-file-name').innerText = this.files[0] ? this.files[0].name : 'Upload File'; document.getElementById('checkout-dl-icon').className = this.files[0] ? 'fa-solid fa-circle-check text-emerald-500 text-base mb-1' : 'fa-solid fa-cloud-arrow-up text-primary text-base mb-1';">
                                                <div class="text-center pointer-events-none">
                                                    <i class="fa-solid fa-cloud-arrow-up text-primary text-base mb-1" id="checkout-dl-icon"></i>
                                                    <p class="text-[10px] font-bold text-gray-700 uppercase" id="checkout-dl-file-name">Upload File</p>
                                                    <span class="text-[8px] text-gray-400 block mt-0.5">PDF, JPG, PNG up to 5MB</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <label class="block text-[9px] font-bold text-gray-500 uppercase tracking-wider">Sales Tax Permit *</label>
                                            <div class="relative flex flex-col items-center justify-center border border-dashed border-gray-300 rounded-xl bg-white p-3 hover:bg-gray-50/50 transition cursor-pointer">
                                                <input type="file" name="sales_tax_permit" :required="deliveryType === 'online_delivery' && selectedAddressId === 'new'" accept=".pdf,.jpg,.jpeg,.png"
                                                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                                                       onchange="document.getElementById('checkout-st-file-name').innerText = this.files[0] ? this.files[0].name : 'Upload File'; document.getElementById('checkout-st-icon').className = this.files[0] ? 'fa-solid fa-circle-check text-emerald-500 text-base mb-1' : 'fa-solid fa-cloud-arrow-up text-primary text-base mb-1';">
                                                <div class="text-center pointer-events-none">
                                                    <i class="fa-solid fa-cloud-arrow-up text-primary text-base mb-1" id="checkout-st-icon"></i>
                                                    <p class="text-[10px] font-bold text-gray-700 uppercase" id="checkout-st-file-name">Upload File</p>
                                                    <span class="text-[8px] text-gray-400 block mt-0.5">PDF, JPG, PNG up to 5MB</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Set default checkbox -->
                                <div class="flex items-center gap-2 pt-1">
                                    <input type="checkbox" name="is_default" id="is_default" value="1" class="rounded border-gray-300 text-primary focus:ring-primary/25 h-3.5 w-3.5 cursor-pointer">
                                    <label for="is_default" class="text-xs font-bold text-gray-600 select-none cursor-pointer">Save as default address</label>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Order Notes (Optional)</label>
                        <textarea name="notes" rows="1.5" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" placeholder="Special delivery instructions.">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Payment Methods -->
                    <h2 class="text-base font-bold text-gray-900 mb-3 pb-1.5 border-b border-gray-100 flex items-center gap-2 mt-4" style="font-family: 'Outfit', sans-serif;">
                        <span class="inline-block w-1 h-4 bg-primary rounded-full"></span>
                        Payment Method
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center p-2.5 border border-gray-200 bg-white rounded-xl cursor-pointer hover:bg-primary/5 hover:border-primary/30 transition shadow-sm relative">
                            <input type="radio" name="payment_method" value="cod" checked class="h-4 w-4 text-primary focus:ring-primary border-gray-300 cursor-pointer">
                            <div class="ml-2.5">
                                <span class="font-bold text-gray-900 text-xs block">Cash on Delivery</span>
                                <span class="text-[10px] text-gray-400">Pay with cash upon arrival</span>
                            </div>
                            <div class="ms-auto text-primary opacity-60">
                                <i class="fa-solid fa-wallet text-base"></i>
                            </div>
                        </label>
                        <label class="flex items-center p-2.5 border border-gray-200 bg-white rounded-xl cursor-pointer hover:bg-primary/5 hover:border-primary/30 transition shadow-sm relative">
                            <input type="radio" name="payment_method" value="stripe" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 cursor-pointer">
                            <div class="ml-2.5 flex-1">
                                <span class="font-bold text-gray-900 text-xs block">Pay with Card</span>
                                <span class="text-[10px] text-gray-400">Visa, Mastercard, Amex &amp; more</span>
                            </div>
                            <div class="ms-auto flex items-center gap-1">
                                <svg viewBox="0 0 38 24" width="28" height="18" xmlns="http://www.w3.org/2000/svg"><rect width="38" height="24" rx="4" fill="#1a1f71"/><path d="M14.5 7l-2.5 10h-2l2.5-10h2zm7 0l-1 4.5c-.4-1-1.5-4.5-1.5-4.5h-2l2.5 10h1.5l3.5-10h-3zm-11 0H8l-3 10h2l.5-2h3l.5 2h2L10.5 7zm-2.5 6.5l1-4 1 4h-2zM28 9.5c0-.8-.6-2.5-3-2.5-2.5 0-3.5 1.5-3.5 3s1 2.5 3 3 2 1 2 1.5-.5 1-1.5 1c-1.5 0-2.5-1-2.5-1L21 16s1 1.5 3.5 1.5c2.3 0 3.5-1.5 3.5-3 0-1.6-1-2.5-3-3s-2-1-2-1.5.4-1 1.5-1c1 0 2 .5 2 .5L28 9.5z" fill="white"/></svg>
                                <svg viewBox="0 0 38 24" width="28" height="18" xmlns="http://www.w3.org/2000/svg"><rect width="38" height="24" rx="4" fill="#f0f0f0"/><circle cx="15" cy="12" r="7" fill="#eb001b"/><circle cx="23" cy="12" r="7" fill="#f79e1b"/><path d="M19 7.4a7 7 0 0 1 0 9.2A7 7 0 0 1 19 7.4z" fill="#ff5f00"/></svg>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Order summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white border border-gray-100 rounded-xl p-4 sticky top-28 shadow-md">
                        <h3 class="text-base font-serif font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2" style="font-family: 'Outfit', sans-serif;">Your Order</h3>
                        
                        <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto mb-3">
                            @foreach($cart as $id => $item)
                                @php
                                    $liveProduct = \App\Models\Product::find($id);
                                    $itemName = $liveProduct ? $liveProduct->name : $item['name'];
                                    $itemPrice = $liveProduct ? ($liveProduct->sale_price ?? $liveProduct->price) : $item['price'];
                                    $itemImage = $liveProduct ? $liveProduct->primary_image_url : $item['image'];
                                @endphp
                                <div class="flex justify-between items-center py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-9 h-9 flex-shrink-0 bg-[#f5faf7] border border-gray-100 rounded-lg p-0.5 flex items-center justify-center">
                                            <img src="{{ $itemImage }}" alt="{{ $itemName }}" class="max-w-full max-h-full object-contain">
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 text-xs leading-tight max-w-[120px] truncate">{{ $itemName }}</h4>
                                            <span class="text-[9px] text-gray-400">Qty: {{ $item['quantity'] }}</span>
                                        </div>
                                    </div>
                                    <span class="font-bold text-gray-900 text-xs">${{ number_format($itemPrice * $item['quantity'], 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-2 mb-3 border-t border-gray-100 pt-2">
                            <div class="flex justify-between text-gray-500 text-xs">
                                <span>Subtotal</span>
                                <span class="font-semibold text-gray-900 font-sans">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500 text-xs">
                                <span>Shipping</span>
                                <span class="text-green-600 font-semibold uppercase text-[9px] tracking-wider">Free</span>
                            </div>
                            <hr class="border-gray-100">
                            <div class="flex justify-between text-xs font-bold text-gray-900">
                                <span>Grand Total</span>
                                <span>${{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-2 rounded-lg tracking-wider text-[11px] transition-all duration-300 shadow-md cursor-pointer hover:shadow-lg transform hover:-translate-y-0.5">
                            PLACE ORDER (${{ number_format($subtotal, 2) }})
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('detect-location-btn').addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Detecting...';

        // Function to run IP-based fallback geolocator
        function runIpFallback() {
            fetch('https://ipapi.co/json/')
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    if (data && data.city) {
                        document.querySelector('input[name="shipping_city"]').value = data.city || '';
                        document.querySelector('input[name="shipping_state"]').value = data.region || data.region_code || '';
                        document.querySelector('input[name="shipping_zip"]').value = data.postal || '';
                        
                        alert('Location resolved via IP address successfully. Please enter your street address details manually.');
                    } else {
                        alert('Could not resolve your location automatically. Please enter your address details manually.');
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    alert('Could not detect location. Please fill your address details manually.');
                });
        }

        // Try standard browser Geolocation
        if (!navigator.geolocation) {
            runIpFallback();
            return;
        }

        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    
                    if (data && data.address) {
                        const addr = data.address;
                        const line1Parts = [
                            addr.house_number,
                            addr.building,
                            addr.road,
                        ].filter(Boolean);
                        const line1 = line1Parts.join(', ') || addr.road || '';
                        
                        const line2Parts = [
                            addr.suburb,
                            addr.neighbourhood,
                            addr.village,
                            addr.city_district,
                        ].filter(Boolean);
                        const line2 = line2Parts.join(', ') || addr.county || '';
                        
                        document.querySelector('input[name="shipping_address"]').value = line1;
                        document.querySelector('input[name="shipping_address2"]').value = line2;
                        document.querySelector('input[name="shipping_city"]').value = addr.city || addr.town || addr.village || addr.county || '';
                        document.querySelector('input[name="shipping_state"]').value = addr.state || '';
                        document.querySelector('input[name="shipping_zip"]').value = addr.postcode || '';
                    } else {
                        runIpFallback();
                    }
                })
                .catch(error => {
                    runIpFallback();
                });
        }, function(error) {
            // Geolocation failed or user denied permission — run the IP fallback instantly
            runIpFallback();
        }, {
            timeout: 6000 // 6 seconds timeout for browser geolocation
        });
    });
</script>
@endpush
