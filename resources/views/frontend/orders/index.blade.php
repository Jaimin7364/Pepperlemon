@extends('layouts.frontend')

@section('title', 'My Orders')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
        <!-- Breadcrumb & Title Inline -->
        <div class="mb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 border-b border-slate-100">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight" style="font-family: 'Outfit', sans-serif;">My Account</h1>
                <p class="text-[10px] text-slate-450 mt-1 flex items-center gap-1.5 font-bold uppercase tracking-wider">
                    <a href="/" class="hover:text-primary transition-colors">Home</a> 
                    <span class="text-slate-300">/</span> 
                    <a href="/dashboard" class="hover:text-primary transition-colors">Dashboard</a>
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-800">My Orders</span>
                </p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-4">
            
            @include('frontend.partials.customer_sidebar')

            <!-- Content Area: Orders list -->
            <div class="w-full lg:w-3/4">
                <div class="max-w-3xl mx-auto space-y-4">

                    <!-- Search and Filter Bar -->
                    <div class="bg-white border border-slate-150 rounded-2xl p-4 shadow-sm">
                        <form method="GET" action="{{ url('/orders') }}" class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 relative">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order ID..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs text-gray-900 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition">
                            </div>
                            <div class="w-full sm:w-44">
                                <select name="status" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 focus:outline-none focus:border-primary">
                                    <option value="">All Order Statuses</option>
                                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                    <option value="processing" @selected(request('status') === 'processing')>Processing</option>
                                    <option value="shipped" @selected(request('status') === 'shipped')>Shipped</option>
                                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                                    <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                                    <option value="failed" @selected(request('status') === 'failed')>Failed</option>
                                </select>
                            </div>
                            @if(request()->filled('search') || request()->filled('status'))
                                <a href="{{ url('/orders') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs transition text-center flex items-center justify-center">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Orders Listing -->
                    <div class="space-y-3.5">
                        @if($orders->isEmpty())
                            <div class="p-10 text-center bg-white border border-slate-100 rounded-2xl shadow-sm">
                                <div class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3.5 border border-slate-100">
                                    <i class="fa-solid fa-box-open text-slate-300 text-xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">No orders found.</h4>
                                <p class="text-slate-400 text-xs mb-4">Try adjusting your filters or search keywords.</p>
                                <a href="{{ url('/shop') }}" class="inline-flex items-center justify-center bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-xl text-xs font-semibold transition-colors shadow-sm">
                                    Shop Catalog
                                </a>
                            </div>
                        @else
                            @foreach($orders as $order)
                                <div x-data="{ open: false }" class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                                    <!-- Summary Row -->
                                    <div @click="open = !open" class="px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 cursor-pointer hover:bg-slate-50/40 transition-colors select-none">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-300', 'dot' => 'bg-amber-600', 'pulse' => true],
                                                'processing' => ['bg' => 'bg-blue-50 text-blue-800 border-blue-300', 'dot' => 'bg-blue-600', 'pulse' => true],
                                                'shipped' => ['bg' => 'bg-indigo-50 text-indigo-800 border-indigo-300', 'dot' => 'bg-indigo-600', 'pulse' => true],
                                                'completed' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-300', 'dot' => 'bg-emerald-600', 'pulse' => false],
                                                'cancelled' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-300', 'dot' => 'bg-rose-600', 'pulse' => false],
                                                'failed' => ['bg' => 'bg-red-50 text-red-800 border-red-300', 'dot' => 'bg-red-600', 'pulse' => false]
                                            ];
                                            $config = $statusConfig[$order->status] ?? ['bg' => 'bg-slate-50 text-slate-800 border-slate-300', 'dot' => 'bg-slate-600', 'pulse' => false];
                                        @endphp
                                        <div class="flex items-center justify-between sm:justify-start gap-3 w-full sm:w-auto">
                                            <div class="flex items-center gap-2.5">
                                                <div class="h-8.5 w-8.5 rounded-xl bg-primary/10 flex items-center justify-center text-primary-dark">
                                                    <i class="fa-solid fa-box-open text-xs text-primary"></i>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-extrabold text-slate-900 text-xs tracking-tight">#{{ $order->order_number }}</span>
                                                    <span class="text-[9px] text-slate-550 mt-0.5 flex items-center gap-1 font-semibold">
                                                        <i class="fa-regular fa-calendar text-[8px]"></i> {{ $order->created_at->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sm:hidden text-right flex items-center gap-2">
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold border {{ $config['bg'] }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] transition-transform duration-300" :class="open ? 'rotate-180 text-primary' : ''"></i>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto mt-1.5 sm:mt-0 border-t border-slate-100/60 pt-2 sm:pt-0 sm:border-0">
                                            <div class="flex items-center -space-x-2.5 overflow-hidden">
                                                @foreach($order->items->take(4) as $item)
                                                    @if($item->product)
                                                        <div class="w-7 h-7 rounded-full border border-white bg-slate-50 flex items-center justify-center shadow-xs overflow-hidden" title="{{ $item->product_name }}">
                                                            <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain">
                                                        </div>
                                                    @else
                                                        <div class="w-7 h-7 rounded-full border border-white bg-slate-50 flex items-center justify-center shadow-xs text-slate-500">
                                                            <i class="fa-solid fa-box text-[8px]"></i>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if($order->items->count() > 4)
                                                    <span class="w-7 h-7 rounded-full border border-white bg-slate-100 text-[8px] font-bold text-slate-655 flex items-center justify-center shadow-xs">
                                                        +{{ $order->items->count() - 4 }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="flex items-center gap-3">
                                                <div class="text-right font-sans">
                                                    <span class="text-xs font-extrabold text-slate-900">${{ number_format($order->total_amount, 2) }}</span>
                                                </div>
                                                <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[9px] font-bold border {{ $config['bg'] }}">
                                                    <span class="relative flex h-1.5 w-1.5">
                                                        @if($config['pulse'])
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 {{ $config['dot'] }}"></span>
                                                        @endif
                                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 {{ $config['dot'] }}"></span>
                                                    </span>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                <i class="hidden sm:block fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300" :class="open ? 'rotate-180 text-primary' : ''"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Collapsible Details -->
                                    <div x-show="open" x-transition class="border-t border-slate-100 bg-[#fbfdfc] px-4 py-3" style="display: none;">
                                        <div class="mb-3">
                                            <div class="flex items-center justify-between mb-2.5 border-b border-slate-150 pb-1.5">
                                                <span class="text-[10px] font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                                    <i class="fa-solid fa-basket-shopping text-slate-500 text-xs"></i> Order Items
                                                </span>
                                                <div x-data="{ copied: false, text: '#{{ $order->order_number }}' }" class="flex items-center gap-1 text-[10px] text-slate-500 font-medium">
                                                    <span>Order ID: <strong class="text-slate-900 font-bold" x-text="text"></strong></span>
                                                    <button @click.stop="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)" class="text-slate-500 hover:text-primary transition-colors p-1" title="Copy Order ID">
                                                        <i class="fa-regular fa-copy text-[10px]" x-show="!copied"></i>
                                                        <i class="fa-solid fa-check text-[10px] text-emerald-600" x-show="copied"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="divide-y divide-slate-150 space-y-1.5">
                                                @foreach($order->items as $item)
                                                    <div class="flex items-center justify-between py-1.5 first:pt-0 last:pb-0">
                                                        <div class="flex items-center gap-2.5">
                                                            @if($item->product)
                                                                <div class="w-9 h-9 rounded-xl bg-white border border-slate-200/80 p-0.5 flex flex-shrink-0 items-center justify-center shadow-xs overflow-hidden">
                                                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain">
                                                                </div>
                                                            @else
                                                                <div class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-150 flex items-center justify-center flex-shrink-0 text-slate-500">
                                                                    <i class="fa-solid fa-box text-xs"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <p class="text-xs font-bold text-slate-900">{{ $item->product_name }}</p>
                                                                <p class="text-[10px] text-slate-600 font-bold mt-0.5">{{ $item->quantity }} × <span class="font-medium text-slate-500">${{ number_format($item->unit_price, 2) }}</span></p>
                                                            </div>
                                                        </div>
                                                        <span class="text-xs font-extrabold text-slate-900">${{ number_format($item->total_price, 2) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Details Card Grid -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-150 pt-3.5 text-xs">
                                            <!-- Payment Details -->
                                            <div>
                                                <h6 class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-credit-card text-[10px] text-primary"></i> Payment Details
                                                </h6>
                                                <div class="space-y-1.5 text-slate-700">
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 font-medium text-[10px]">Method</span>
                                                        <span class="font-extrabold text-slate-800 bg-slate-100 px-2 py-0.5 rounded text-[9px] uppercase tracking-wide">
                                                            {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : strtoupper($order->payment_method) }}
                                                        </span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 font-medium text-[10px]">Status</span>
                                                        @php
                                                            $paymentColors = [
                                                                'completed' => 'bg-emerald-50 text-emerald-800 border-emerald-250',
                                                                'pending' => 'bg-amber-50 text-amber-800 border-amber-250',
                                                                'failed' => 'bg-rose-50 text-rose-800 border-rose-250'
                                                            ];
                                                            $payColor = $paymentColors[$order->payment_status] ?? 'bg-slate-55 text-slate-850 border-slate-250';
                                                        @endphp
                                                        <span class="font-bold border px-2 py-0.5 rounded text-[9px] uppercase tracking-wide {{ $payColor }}">
                                                            {{ $order->payment_status }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Shipping Details -->
                                            <div>
                                                <h6 class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                                    @if($order->delivery_type === 'self_pickup')
                                                        <i class="fa-solid fa-house-chimney text-[10px] text-amber-600"></i> Pickup Details
                                                    @else
                                                        <i class="fa-solid fa-truck-fast text-[10px] text-primary"></i> Shipping Details
                                                    @endif
                                                </h6>
                                                <div class="text-[10px] text-slate-700 space-y-1.5">
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 font-medium text-[10px]">Method</span>
                                                        <span class="font-extrabold text-right uppercase text-[9px] px-2 py-0.5 rounded-full {{ $order->delivery_type === 'self_pickup' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                                            {{ $order->delivery_type === 'self_pickup' ? 'Self Pickup' : 'Online Delivery' }}
                                                        </span>
                                                    </div>
                                                    @if($order->delivery_type !== 'self_pickup')
                                                        <div class="flex justify-between">
                                                            <span class="text-slate-500 font-medium text-[10px]">Recipient</span>
                                                            <span class="font-extrabold text-slate-900 text-right">{{ $order->shipping_name }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="flex justify-between gap-2 items-start">
                                                        <span class="text-slate-500 font-medium text-[10px] flex-shrink-0">Address</span>
                                                        <span class="font-bold text-slate-850 text-right leading-normal break-words max-w-[200px]">
                                                            {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}
                                                        </span>
                                                    </div>
                                                    @if($order->delivery_type !== 'self_pickup' && $order->shipping_phone)
                                                        <div class="flex justify-between">
                                                            <span class="text-slate-500 font-medium text-[10px]">Phone</span>
                                                            <span class="font-extrabold text-slate-900 text-right">{{ $order->shipping_phone }}</span>
                                                        </div>
                                                    @endif

                                                    @if($order->delivery_type === 'online_delivery' && $order->ups_tracking_number)
                                                        <div class="pt-2 border-t border-slate-100 space-y-1">
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-slate-500 font-medium text-[10px]">UPS Tracking</span>
                                                                <span class="font-mono font-bold text-slate-800">{{ $order->ups_tracking_number }}</span>
                                                            </div>
                                                            <a href="https://www.ups.com/track?tracknum={{ $order->ups_tracking_number }}" target="_blank"
                                                               class="w-full text-center block text-white font-extrabold text-[9px] py-1.5 rounded-lg transition"
                                                               style="background: #351C15;">
                                                                <i class="fa-solid fa-magnifying-glass text-[8px] mr-1"></i> Track on UPS.com
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Return Order B2B Request Section -->
                                        @if($order->status === 'completed' && $order->return_status === null)
                                            <div class="mt-4 pt-3.5 border-t border-slate-150">
                                                <div x-data="{ showReturnForm: false }">
                                                    <button type="button" @click.stop="showReturnForm = !showReturnForm" 
                                                            class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-3.5 py-2 rounded-xl text-xs font-bold transition-all">
                                                        <i class="fa-solid fa-arrow-rotate-left"></i>
                                                        <span>Request Return</span>
                                                    </button>

                                                    <form x-show="showReturnForm" @click.stop="" action="{{ route('orders.return', $order->id) }}" method="POST" class="mt-3 bg-red-50/20 border border-red-150 rounded-xl p-3.5 space-y-3">
                                                        @csrf
                                                        <div>
                                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Reason for Return <span class="text-red-500">*</span></label>
                                                            <select name="return_reason" required class="w-full border border-slate-200 focus:ring-1 focus:ring-red-500 focus:border-red-500 rounded-lg text-xs px-3 py-2 bg-white">
                                                                <option value="">Select a reason</option>
                                                                <option value="Damaged Goods">Damaged / Defective Goods</option>
                                                                <option value="Incorrect Item">Incorrect Item Shipped</option>
                                                                <option value="Short Shipment">Short Shipment (Missing Units)</option>
                                                                <option value="Quality Issues">Quality Not Satisfactory</option>
                                                                <option value="Other">Other (Specify in comments)</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Comments / Details <span class="text-red-500">*</span></label>
                                                            <textarea name="return_comments" rows="2" required placeholder="Describe the issue, include damaged quantities or product names..." class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-gray-900 shadow-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/20 transition"></textarea>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-lg text-xs transition">Submit Return Request</button>
                                                            <button type="button" @click="showReturnForm = false" class="bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold px-4 py-2 rounded-lg text-xs transition">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Return Status Display -->
                                        @if($order->return_status !== null)
                                            <div class="mt-4 pt-3.5 border-t border-slate-150 bg-slate-50/50 p-3 rounded-xl border border-slate-150">
                                                <h6 class="text-[10px] font-extrabold text-slate-655 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-arrow-rotate-left text-red-500"></i> Return Request Details
                                                </h6>
                                                <div class="text-[10px] text-slate-700 space-y-1.5">
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-550 font-medium">Return Status</span>
                                                        <span class="font-extrabold text-[9px] uppercase px-2 py-0.5 rounded-full {{ $order->return_status === 'approved' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($order->return_status === 'rejected' ? 'bg-rose-50 text-rose-800 border border-rose-200' : 'bg-amber-50 text-amber-800 border border-amber-200') }}">
                                                            Return {{ ucfirst($order->return_status) }}
                                                        </span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-555 font-medium">Reason</span>
                                                        <span class="font-bold text-slate-850">{{ $order->return_reason }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-slate-555 font-medium block mb-0.5">Comments</span>
                                                        <p class="bg-white p-2 border border-slate-150 rounded-lg text-slate-600 leading-normal font-medium">{{ $order->return_comments }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- Pagination -->
                            <div class="mt-4 pt-2">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
