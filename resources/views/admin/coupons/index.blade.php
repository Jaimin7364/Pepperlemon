@extends('layouts.admin')

@section('header_title', 'Manage Coupons')

@section('content')
<div class="space-y-6">

    <!-- Actions Panel -->
    <div class="flex justify-end items-center bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
        <a href="{{ route('admin.coupons.create') }}" class="w-full sm:w-auto text-center bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md shadow-[#C49A6C]/25 transition cursor-pointer flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Add Coupon</span>
        </a>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Code</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Value</th>
                        <th class="px-6 py-4">Expiry Date</th>
                        <th class="px-6 py-4">Usage Limit (Used)</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-bold text-slate-800 tracking-wider font-mono uppercase text-sm bg-slate-50/30">{{ $coupon->code }}</td>
                            <td class="px-6 py-4">
                                @if($coupon->type === 'fixed')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-blue-50 text-blue-700">Fixed Discount</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-purple-50 text-purple-700">Percentage %</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900">
                                @if($coupon->type === 'fixed')
                                    ${{ number_format($coupon->value, 2) }}
                                @else
                                    {{ number_format($coupon->value) }}%
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                @if($coupon->expiry_date)
                                    <span class="{{ \Carbon\Carbon::parse($coupon->expiry_date)->isPast() ? 'text-rose-500 font-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400">Never Expires</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-700">
                                    {{ $coupon->used }} / {{ $coupon->usage_limit ?: '∞' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($coupon->is_active && (!$coupon->expiry_date || !\Carbon\Carbon::parse($coupon->expiry_date)->isPast()))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Inactive/Expired</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="p-2 bg-slate-100 hover:bg-[#C49A6C] hover:text-white rounded-lg text-slate-600 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" onsubmit="return confirm('Are you sure you want to delete this coupon?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-slate-100 hover:bg-red-500 hover:text-white rounded-lg text-slate-600 transition cursor-pointer" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400 font-medium">No coupons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($coupons->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
