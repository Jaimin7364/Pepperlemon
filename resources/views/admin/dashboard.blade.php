@extends('layouts.admin')

@section('header_title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    
    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs flex items-center space-x-4">
            <div class="bg-amber-50 text-[#C49A6C] h-12 w-12 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Sales</span>
                <span class="block text-xl font-bold text-slate-900 mt-0.5">${{ number_format($totalSales) }}</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs flex items-center space-x-4">
            <div class="bg-blue-50 text-blue-500 h-12 w-12 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Orders</span>
                <span class="block text-xl font-bold text-slate-900 mt-0.5">{{ $totalOrders }}</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs flex items-center space-x-4">
            <div class="bg-orange-50 text-orange-500 h-12 w-12 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Pending Orders</span>
                <span class="block text-xl font-bold text-slate-900 mt-0.5">{{ $pendingOrders }}</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs flex items-center space-x-4">
            <div class="bg-emerald-50 text-emerald-500 h-12 w-12 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Completed Orders</span>
                <span class="block text-xl font-bold text-slate-900 mt-0.5">{{ $completedOrders }}</span>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs flex items-center space-x-4">
            <div class="bg-purple-50 text-purple-500 h-12 w-12 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Products</span>
                <span class="block text-xl font-bold text-slate-900 mt-0.5">{{ $totalProducts }}</span>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs flex items-center space-x-4">
            <div class="bg-indigo-50 text-indigo-500 h-12 w-12 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Customers</span>
                <span class="block text-xl font-bold text-slate-900 mt-0.5">{{ $totalUsers }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-serif font-bold text-slate-800 text-lg">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-[#C49A6C] hover:underline">View All Orders</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Order No.</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <span class="block font-medium text-slate-850">{{ $order->shipping_name }}</span>
                                <span class="block text-xs text-slate-400">{{ $order->shipping_email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                        Completed
                                    </span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                        Processing
                                    </span>
                                @elseif($order->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-700">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-700">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $order->created_at->format('M d, Y g:i A') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-[#C49A6C] hover:text-white px-3.5 py-2 rounded-lg transition duration-200">
                                    Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400 font-medium">No recent orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
