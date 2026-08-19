@extends('layouts.frontend')

@section('title', 'Order Success')

@section('content')
    @php
        // Eager load items and products for the summary
        $order->load('items.product');

        // Dynamic Status Configurations
        $statusConfigs = [
            'pending' => [
                'title' => 'Order Placed Successfully!',
                'desc' => 'Thank you for your purchase. We have received your order and are processing it.',
                'icon' => 'fa-circle-check',
                'color' => 'text-emerald-600 bg-green-50 border-green-100',
                'ping' => 'bg-emerald-500/10'
            ],
            'processing' => [
                'title' => 'Order is Processing!',
                'desc' => 'We have accepted your order and our warehouse team is preparing your items.',
                'icon' => 'fa-spinner fa-spin-pulse',
                'color' => 'text-blue-600 bg-blue-50 border-blue-100',
                'ping' => 'bg-blue-500/10'
            ],
            'shipped' => [
                'title' => 'Order is Shipped!',
                'desc' => 'Great news! Your package has shipped and is on the way. Tracking info is listed below.',
                'icon' => 'fa-truck-fast',
                'color' => 'text-[#C49A6C] bg-amber-50 border-amber-100',
                'ping' => 'bg-[#C49A6C]/10'
            ],
            'delivered' => [
                'title' => 'Order Delivered Successfully!',
                'desc' => 'Your shipment has arrived at its destination. Thank you for shopping with us!',
                'icon' => 'fa-house-circle-check',
                'color' => 'text-emerald-700 bg-emerald-55 border-emerald-150',
                'ping' => 'bg-emerald-500/10'
            ],
            'cancelled' => [
                'title' => 'Order Cancelled',
                'desc' => 'This order was cancelled. If you have any questions, please contact customer support.',
                'icon' => 'fa-circle-xmark',
                'color' => 'text-rose-600 bg-rose-50 border-rose-100',
                'ping' => 'bg-rose-500/10'
            ],
            'return_requested' => [
                'title' => 'Return Requested',
                'desc' => 'A return request has been submitted for this order. Our admin team is reviewing your details.',
                'icon' => 'fa-clock-rotate-left',
                'color' => 'text-indigo-600 bg-indigo-50 border-indigo-100',
                'ping' => 'bg-indigo-500/10'
            ],
            'returned' => [
                'title' => 'Order Returned',
                'desc' => 'This order was successfully returned. Refunds or adjustments have been updated.',
                'icon' => 'fa-rotate-left',
                'color' => 'text-slate-600 bg-slate-100 border-slate-200',
                'ping' => 'bg-slate-500/10'
            ],
            'return_rejected' => [
                'title' => 'Return Rejected',
                'desc' => 'Your return request was reviewed and not approved. Please consult support for next steps.',
                'icon' => 'fa-triangle-exclamation',
                'color' => 'text-rose-700 bg-rose-50 border-rose-150',
                'ping' => 'bg-rose-500/10'
            ]
        ];

        $currentConfig = $statusConfigs[$order->status] ?? $statusConfigs['pending'];
    @endphp

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <!-- Success Alert Header -->
        <div class="text-center mb-10">
            <!-- Animated Dynamic Success Checkmark Badge -->
            <div class="inline-flex items-center justify-center p-5 rounded-full mb-6 border shadow-sm relative {{ $currentConfig['color'] }}">
                <span class="absolute inset-0 rounded-full animate-ping opacity-75 {{ $currentConfig['ping'] }}"></span>
                <i class="fa-solid {{ $currentConfig['icon'] }} text-6xl relative z-10"></i>
            </div>

            <h1 class="text-3xl sm:text-4xl font-serif font-black text-gray-900 mb-3 tracking-tight">{{ $currentConfig['title'] }}</h1>
            <p class="text-gray-500 max-w-lg mx-auto text-xs sm:text-sm leading-relaxed">
                {{ $currentConfig['desc'] }}
                @if($order->status === 'pending')
                    An email confirmation has been sent to 
                    <span class="inline-block px-2 py-0.5 font-bold text-gray-900 bg-gray-100 rounded-md font-sans">{{ $order->shipping_email }}</span>.
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Order Details Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Info Grid -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-serif font-bold text-gray-900 mb-4 pb-3 border-b border-gray-50 flex items-center justify-between">
                        <span>Order Information</span>
                        @if($order->payment_status === 'completed')
                            <span class="text-[10px] uppercase tracking-wider text-emerald-600 bg-emerald-50 font-bold px-2 py-0.5 rounded">Paid</span>
                        @elseif($order->payment_status === 'failed')
                            <span class="text-[10px] uppercase tracking-wider text-rose-600 bg-rose-50 font-bold px-2 py-0.5 rounded">Payment Failed</span>
                        @else
                            <span class="text-[10px] uppercase tracking-wider text-amber-600 bg-amber-50 font-bold px-2 py-0.5 rounded">Pending</span>
                        @endif
                    </h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-6">
                        <div>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest block font-bold">Order Number</span>
                            <span class="font-mono font-bold text-gray-900 text-sm">{{ $order->order_number }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest block font-bold">Date Placed</span>
                            <span class="font-bold text-gray-700 text-xs sm:text-sm font-sans">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest block font-bold">Order Status</span>
                            <span class="font-bold text-slate-800 text-xs sm:text-sm capitalize flex items-center gap-1.5 mt-0.5">
                                @if($order->status === 'completed')
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                @elseif($order->status === 'processing')
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Processing
                                @elseif($order->status === 'shipped')
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#C49A6C]"></span> Shipped
                                @elseif($order->status === 'cancelled')
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Cancelled
                                @elseif($order->status === 'return_requested')
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse"></span> Return Requested
                                @elseif($order->status === 'returned')
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Returned
                                @elseif($order->status === 'return_rejected')
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-700"></span> Return Rejected
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Pending
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest block font-bold">Payment Method</span>
                            <span class="font-bold text-gray-700 text-xs sm:text-sm uppercase">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest block font-bold">Total Amount</span>
                            <span class="font-extrabold text-primary text-sm sm:text-base">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Items Purchased List -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-serif font-bold text-gray-900 mb-4 pb-3 border-b border-gray-50">Items Ordered</h3>
                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            @php
                                $productImage = $item->product ? $item->product->primary_image_url : asset('images/logo.jpeg');
                            @endphp
                            <div class="py-3 flex items-center gap-3 first:pt-0 last:pb-0">
                                <!-- Thumb -->
                                <div class="w-12 h-12 flex-shrink-0 bg-[#f5faf7] border border-gray-100 rounded-xl p-1 flex items-center justify-center">
                                    <img src="{{ $productImage }}" alt="{{ $item->product_name }}" class="max-w-full max-h-full object-contain">
                                </div>
                                <!-- Title/Qty -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 text-xs sm:text-sm truncate leading-tight">{{ $item->product_name }}</h4>
                                    <p class="text-[10px] text-gray-400 mt-1">${{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}</p>
                                </div>
                                <!-- Price Total -->
                                <div class="text-right">
                                    <span class="font-extrabold text-gray-900 text-xs sm:text-sm">${{ number_format($item->total_price, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Delivery & Shipping Information Side Card -->
            <div class="space-y-6">
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm h-full">
                    <h3 class="text-base font-serif font-bold text-gray-900 mb-4 pb-3 border-b border-gray-50 flex items-center gap-2">
                        @if($order->delivery_type === 'self_pickup')
                            <i class="fa-solid fa-house-chimney text-gray-400"></i>
                            <span>Pickup Location</span>
                        @else
                            <i class="fa-solid fa-truck-ramp-box text-gray-400"></i>
                            <span>Shipping Address</span>
                        @endif
                    </h3>
                    <div class="space-y-3">
                        <div class="bg-[#f5faf7]/40 border border-gray-55/60 rounded-xl p-4">
                            @if($order->delivery_type === 'self_pickup')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-700 mb-2 uppercase tracking-wide">Self Pickup</span>
                                <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm leading-tight mb-2">Warehouse Pickup</h4>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-blue-50 text-blue-700 mb-2 uppercase tracking-wide">Online Delivery</span>
                                <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm leading-tight mb-2">{{ $order->shipping_name }}</h4>
                            @endif
                            <p class="text-[11px] sm:text-xs text-gray-600 leading-relaxed font-medium">
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                                Postal Code: {{ $order->shipping_zip }}
                            </p>
                        </div>

                        @if($order->delivery_type === 'self_pickup')
                            <div class="flex items-center gap-2.5 px-1 py-0.5">
                                <i class="fa-solid fa-envelope text-xs text-gray-400"></i>
                                <span class="text-[11px] sm:text-xs font-bold text-gray-700">{{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</span>
                            </div>
                        @else
                            <div class="flex items-center gap-2.5 px-1 py-0.5">
                                <i class="fa-solid fa-phone text-xs text-gray-400"></i>
                                <span class="text-[11px] sm:text-xs font-bold text-gray-700">{{ $order->shipping_phone }}</span>
                            </div>
                        @endif

                        @if($order->delivery_type === 'online_delivery' && $order->ups_tracking_number)
                            <div class="pt-3 border-t border-gray-100 space-y-2">
                                <span class="text-[10px] text-gray-400 uppercase tracking-widest block font-bold">UPS Tracking Number</span>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 flex items-center justify-between">
                                    <span class="font-mono text-xs font-bold text-gray-800 select-all">{{ $order->ups_tracking_number }}</span>
                                    <a href="https://www.ups.com/track?tracknum={{ $order->ups_tracking_number }}" target="_blank" class="text-[10px] bg-primary text-white font-extrabold px-2.5 py-1.5 rounded-lg hover:bg-primary-dark transition cursor-pointer">
                                        Track
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Call Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center max-w-md mx-auto">
            <a href="/shop" class="w-full sm:w-auto flex-grow bg-primary hover:bg-primary-dark text-white font-bold py-3 px-8 rounded-xl tracking-wider text-xs transition duration-200 text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                CONTINUE SHOPPING
            </a>
            @if(auth()->check())
                <a href="/dashboard" class="w-full sm:w-auto flex-grow bg-white border border-gray-200 hover:border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl tracking-wider text-xs transition duration-200 text-center shadow-sm">
                    GO TO DASHBOARD
                </a>
            @else
                <a href="/login" class="w-full sm:w-auto flex-grow bg-white border border-gray-200 hover:border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl tracking-wider text-xs transition duration-200 text-center shadow-sm">
                    LOGIN TO TRACK ORDER
                </a>
            @endif
        </div>
    </div>
@endsection

