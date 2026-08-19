@extends('layouts.admin')

@section('header_title', 'Manage Orders')

@section('content')
<div class="space-y-6">

    <!-- Actions Panel -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order No, name, email..." 
                   class="w-full sm:w-72 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
            
            <select name="status" class="w-full sm:w-44 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
                <option value="">All Statuses</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="processing" @selected(request('status') === 'processing')>Processing</option>
                <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                <option value="failed" @selected(request('status') === 'failed')>Failed</option>
                <option value="return_requested" @selected(request('status') === 'return_requested')>Return Requested</option>
                <option value="returned" @selected(request('status') === 'returned')>Returned</option>
                <option value="return_rejected" @selected(request('status') === 'return_rejected')>Return Rejected</option>
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition cursor-pointer">
                Filter
            </button>
            
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Clear</a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Order No.</th>
                        <th class="px-6 py-4">Customer Details</th>
                        <th class="px-6 py-4">Payment Method</th>
                        <th class="px-6 py-4">Payment Status</th>
                        <th class="px-6 py-4">Order Status</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Created Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <span class="block font-medium text-slate-850">{{ $order->shipping_name }}</span>
                                <span class="block text-xs text-slate-450">{{ $order->shipping_email }}</span>
                                <span class="block text-[10px] text-slate-400 font-medium">{{ $order->shipping_phone }}</span>
                            </td>
                            <td class="px-6 py-4 uppercase font-semibold text-slate-600 text-xs">{{ $order->payment_method }}</td>
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">Paid</span>
                                @elseif($order->payment_status === 'failed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700">Failed</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-50 text-orange-700">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($order->return_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 animate-pulse border border-rose-350">Return Requested</span>
                                @elseif($order->status === 'returned' || $order->return_status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-750">Returned</span>
                                @elseif($order->status === 'return_rejected' || $order->return_status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Return Rejected</span>
                                @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-750">Completed</span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-750">Processing</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Cancelled</span>
                                @elseif($order->status === 'failed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700">Failed</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-755">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $order->created_at->format('M d, Y g:i A') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-[#C49A6C] hover:text-white px-3.5 py-2.5 rounded-lg transition duration-200">
                                    Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-slate-400 font-medium">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
