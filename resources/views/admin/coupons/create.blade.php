@extends('layouts.admin')

@section('header_title', 'Create Coupon')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <h3 class="font-serif font-bold text-slate-800 text-lg">Add New Coupon</h3>
        <a href="{{ route('admin.coupons.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Coupons</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-xl text-rose-800 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Code -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Coupon Code *</label>
                <input type="text" name="code" value="{{ old('code') }}" required placeholder="e.g. PEPPER10"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 font-mono uppercase">
            </div>

            <!-- Discount Type -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Discount Type *</label>
                <select name="type" required class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                    <option value="fixed" @selected(old('type') === 'fixed')>Fixed Amount ($)</option>
                    <option value="percent" @selected(old('type') === 'percent')>Percentage (%)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Value -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Discount Value *</label>
                <input type="number" name="value" step="0.01" min="0" value="{{ old('value') }}" required placeholder="e.g. 50.00 or 10"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- Expiry Date -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Expiry Date (Optional)</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Usage Limit -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Usage Limit (Optional)</label>
                <input type="number" name="usage_limit" min="1" value="{{ old('usage_limit') }}" placeholder="Leave blank for unlimited"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- Status -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status</label>
                <label class="flex items-center space-x-3 cursor-pointer border border-slate-200 rounded-xl px-4 py-2.5 bg-white h-[45px]">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))
                           class="rounded border-slate-350 text-[#C49A6C] focus:ring-[#C49A6C] h-4.5 w-4.5">
                    <span class="text-sm font-semibold text-slate-700">Active</span>
                </label>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.coupons.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-250 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Save Coupon
            </button>
        </div>
    </form>

</div>
@endsection
