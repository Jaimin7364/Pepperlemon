@extends('layouts.admin')

@section('header_title', 'Order Details')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-serif font-bold text-slate-800 text-lg">Order: {{ $order->order_number }}</h3>
            <span class="text-xs text-slate-450 mt-1 block">Placed on: {{ $order->created_at->format('M d, Y g:i A') }}</span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Orders</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Columns: Items & Address -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Ordered Items Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50">Line Items</h4>
                <div class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                            <div class="flex items-center space-x-4">
                                @php
                                    $product = $item->product;
                                    $image = $product ? $product->primary_image_url : asset('images/logo.jpeg');
                                @endphp
                                <img src="{{ $image }}" alt="{{ $item->product_name }}" class="h-14 w-14 rounded-xl object-contain bg-slate-50 border border-slate-100 p-1 flex-shrink-0">
                                <div>
                                    <span class="block font-semibold text-slate-800">{{ $item->product_name }}</span>
                                    <span class="block text-xs text-slate-400 mt-1">Quantity: {{ $item->quantity }} @ ${{ number_format($item->unit_price, 2) }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-900">${{ number_format($item->total_price, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-sm font-semibold text-slate-500">Order Total</span>
                    <span class="text-lg font-bold text-slate-950">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Shipping Information Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50 flex items-center justify-between">
                    <span>{{ $order->delivery_type === 'self_pickup' ? 'Pickup Details' : 'Shipping Details' }}</span>
                    <span class="text-xs uppercase font-bold px-2 py-0.5 rounded-full {{ $order->delivery_type === 'self_pickup' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                        {{ $order->delivery_type === 'self_pickup' ? 'Self Pickup' : 'Online Delivery' }}
                    </span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-slate-650">
                    @if($order->delivery_type !== 'self_pickup')
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Recipient Name</span>
                            <span class="block font-semibold text-slate-800 mt-1">{{ $order->shipping_name }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Contact Number</span>
                            <span class="block font-semibold text-slate-800 mt-1">{{ $order->shipping_phone }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Email Address</span>
                        <span class="block font-semibold text-slate-800 mt-1">{{ $order->shipping_email }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">{{ $order->delivery_type === 'self_pickup' ? 'Warehouse Pickup Address' : 'Delivery Address' }}</span>
                        <span class="block font-semibold text-slate-800 mt-1 leading-relaxed">
                            {{ $order->shipping_address }},<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}
                        </span>
                    </div>
                </div>
                @if($order->driving_license || $order->sales_tax_permit)
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-2">B2B Customer Documents</span>
                        <div class="flex flex-wrap gap-3">
                            @if($order->driving_license)
                                <a href="{{ asset($order->driving_license) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-xl transition shadow-3xs">
                                    <i class="fa-solid fa-id-card text-slate-500"></i> View Driving License
                                </a>
                            @endif
                            @if($order->sales_tax_permit)
                                <a href="{{ asset($order->sales_tax_permit) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-xl transition shadow-3xs">
                                    <i class="fa-solid fa-file-invoice-dollar text-slate-500"></i> View Sales Tax Permit
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
                @if($order->notes)
                    <div class="mt-6 p-4 bg-slate-50 border border-slate-100 rounded-xl text-xs leading-relaxed text-slate-500">
                        <span class="font-bold text-slate-600 block mb-1">Customer Order Notes:</span>
                        "{{ $order->notes }}"
                    </div>
                @endif
            </div>

        </div>

        <!-- Right 1 Column: Manage Status -->
        <div class="space-y-6">
            
            <!-- Update Order Status Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50">Update Status</h4>
                
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <!-- Order Status -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Order Status</label>
                        <select name="status" class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                            <option value="pending" @selected($order->status === 'pending')>Pending</option>
                            <option value="processing" @selected($order->status === 'processing')>Processing</option>
                            <option value="shipped" @selected($order->status === 'shipped')>Shipped</option>
                            <option value="completed" @selected($order->status === 'completed')>Completed</option>
                            <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                            <option value="failed" @selected($order->status === 'failed')>Failed</option>
                            <option value="returned" @selected($order->status === 'returned')>Returned (B2B)</option>
                            <option value="return_rejected" @selected($order->status === 'return_rejected')>Return Rejected (B2B)</option>
                        </select>
                    </div>

                    <!-- Payment Status -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Payment Status</label>
                        <select name="payment_status" class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                            <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                            <option value="completed" @selected($order->payment_status === 'completed')>Paid (Completed)</option>
                            <option value="failed" @selected($order->payment_status === 'failed')>Failed</option>
                        </select>
                    </div>

                    <!-- UPS Tracking ID (only visible for online delivery) -->
                    @if($order->delivery_type === 'online_delivery')
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">UPS Tracking Number</label>
                            <input type="text" name="ups_tracking_number" value="{{ old('ups_tracking_number', $order->ups_tracking_number) }}" 
                                   placeholder="e.g. 1Z999AA10123456784"
                                   class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white font-mono">
                        </div>
                    @endif

                    <!-- Return Request Processing (Only shown if return has been requested) -->
                    @if($order->return_status !== null)
                        <div class="space-y-1.5 pt-3 border-t border-slate-150">
                            <label class="text-xs font-bold text-red-600 uppercase tracking-wider block">B2B Return Request Status</label>
                            <select name="return_status" class="w-full border border-red-200 focus:ring-1 focus:ring-red-500 focus:border-red-500 rounded-xl text-sm px-4 py-2.5 bg-white font-bold text-red-700">
                                <option value="pending" @selected($order->return_status === 'pending')>Pending Review</option>
                                <option value="approved" @selected($order->return_status === 'approved')>Approve Return</option>
                                <option value="rejected" @selected($order->return_status === 'rejected')>Reject Return</option>
                            </select>
                            
                            <div class="bg-red-50/30 border border-red-150 rounded-xl p-3.5 mt-2 space-y-2 text-xs">
                                <div>
                                    <span class="block text-[9px] uppercase font-bold text-red-500">Return Reason</span>
                                    <span class="block font-semibold text-slate-800 mt-0.5">{{ $order->return_reason }}</span>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase font-bold text-red-500">Customer Comments</span>
                                    <p class="text-slate-650 font-medium leading-normal mt-0.5">{{ $order->return_comments }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="w-full bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm py-3 rounded-xl transition cursor-pointer shadow-md shadow-[#C49A6C]/25">
                        Update Details
                    </button>                </form>
            </div>

            <!-- UPS Shipping Information Display Card -->
            @if($order->delivery_type === 'online_delivery')
                <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6 text-sm text-slate-650 space-y-4">
                    <h4 class="font-serif font-bold text-slate-800 text-base pb-2 border-b border-slate-50 flex items-center justify-between">
                        <span>UPS Tracking Info</span>
                        <i class="fa-solid fa-truck-fast text-[#351C15]"></i>
                    </h4>

                    @if($order->ups_tracking_number)
                        <div class="space-y-3">
                            <div>
                                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tracking Number</span>
                                <span class="block font-semibold text-slate-800 mt-0.5 font-mono text-xs select-all">{{ $order->ups_tracking_number }}</span>
                            </div>

                            <div class="pt-2">
                                <a href="https://www.ups.com/track?tracknum={{ $order->ups_tracking_number }}" target="_blank"
                                   class="w-full text-center block text-white font-bold text-xs py-2.5 rounded-xl transition"
                                   style="background: #351C15;">
                                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Track on UPS.com
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic">No tracking number has been added to this order yet. Use the status update form above to add a tracking ID.</p>
                    @endif
                </div>
            @endif


            <!-- Transaction Information Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6 text-sm text-slate-650 space-y-4">
                <h4 class="font-serif font-bold text-slate-800 text-base pb-2 border-b border-slate-50">Payment Info</h4>
                
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Method</span>
                    <span class="block font-semibold text-slate-800 mt-1 uppercase">{{ $order->payment_method }}</span>
                </div>

                @if($order->payment_method === 'stripe')
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Stripe Payment Intent</span>
                        <span class="block font-semibold text-slate-800 mt-1 font-mono text-xs select-all">{{ $order->stripe_payment_intent_id ?: 'N/A' }}</span>
                    </div>
                @else
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">COD Information</span>
                        <span class="block text-slate-500 mt-1 leading-relaxed">Collect cash upon delivery. Collect exactly ${{ number_format($order->total_amount, 2) }}.</span>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
