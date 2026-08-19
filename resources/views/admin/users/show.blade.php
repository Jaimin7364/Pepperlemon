@extends('layouts.admin')

@section('header_title', 'Customer Profile Details')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Back to listing -->
    <div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 font-bold transition">
            <i class="fa-solid fa-arrow-left-long"></i> Back to Customers List
        </a>
    </div>

    <!-- Customer Summary Card -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-tr from-[#C49A6C] to-[#b0875b] text-white h-16 w-16 rounded-full flex items-center justify-center font-extrabold text-2xl shadow-sm select-none">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="font-serif font-bold text-slate-900 text-xl">{{ $user->name }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-1.5 text-xs text-slate-500 font-medium">
                    <span><i class="fa-solid fa-envelope text-slate-400 mr-1 text-[10px]"></i> {{ $user->email }}</span>
                    <span><i class="fa-solid fa-phone text-slate-400 mr-1 text-[10px]"></i> {{ $user->phone ?? 'No Phone' }}</span>
                    <span><i class="fa-solid fa-calendar-days text-slate-400 mr-1 text-[10px]"></i> Joined {{ $user->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            @if($user->is_active)
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-750 border border-emerald-200 text-[10px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider">
                    <i class="fa-solid fa-circle-check"></i> Active
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-750 border border-rose-200 text-[10px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider">
                    <i class="fa-solid fa-circle-xmark"></i> Deactivated
                </span>
            @endif

            <form method="POST" action="{{ route('admin.users.toggleStatus', $user) }}" class="m-0" onsubmit="return confirm('Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} this customer\'s account?');">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="inline-flex items-center gap-1.5 border rounded-xl px-3 py-2 font-bold transition shadow-xs text-xs cursor-pointer {{ $user->is_active ? 'bg-rose-50 hover:bg-rose-100 border-rose-200 text-rose-700' : 'bg-emerald-50 hover:bg-emerald-100 border-emerald-200 text-emerald-700' }}">
                    @if($user->is_active)
                        <i class="fa-solid fa-user-slash text-[11px]"></i> Deactivate Account
                    @else
                        <i class="fa-solid fa-user-check text-[11px]"></i> Activate Account
                    @endif
                </button>
            </form>
        </div>
    </div>

    <!-- Customer Addresses & Documents -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs space-y-4">
        <h3 class="font-serif font-bold text-slate-800 text-base pb-3.5 border-b border-slate-100 flex items-center gap-1.5">
            <i class="fa-solid fa-map-location-dot text-[#C49A6C]"></i> Customer Saved Addresses & B2B Documents
        </h3>

        @if($user->addresses->isEmpty())
            <div class="text-center py-12 text-slate-400">
                <i class="fa-solid fa-folder-open text-4xl mb-2 text-slate-200"></i>
                <p class="text-xs font-semibold">This customer hasn't saved any addresses yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                @foreach($user->addresses as $addr)
                    <div class="border {{ $addr->is_default ? 'border-[#C49A6C] bg-[#C49A6C]/2.5' : 'border-slate-100 bg-slate-50/50' }} rounded-xl p-4 flex flex-col justify-between transition hover:border-slate-200">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold text-slate-550 uppercase tracking-wider">Address #{{ $loop->iteration }}</span>
                                @if($addr->is_default)
                                    <span class="bg-[#C49A6C] text-white text-[8px] font-extrabold uppercase px-2 py-0.5 rounded-full tracking-wider">Default</span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-900 font-bold mb-1 leading-normal">
                                {{ $addr->address }}@if($addr->address2), {{ $addr->address2 }}@endif
                            </p>
                            <p class="text-[11px] text-slate-500 font-medium">
                                {{ $addr->city }}, {{ $addr->state }} - {{ $addr->zip }}
                            </p>
                            <p class="text-[11px] text-slate-500 font-medium mt-1">
                                <i class="fa-solid fa-phone text-slate-400 mr-1 text-[9px]"></i> {{ $addr->phone }}
                            </p>

                            <!-- Document Verification Files -->
                            <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-col gap-2">
                                <span class="block text-[9px] uppercase font-bold text-slate-400 tracking-wider">B2B Uploads</span>
                                
                                @if($addr->driving_license)
                                    <a href="{{ asset($addr->driving_license) }}" target="_blank" 
                                       class="inline-flex items-center justify-between bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold px-3 py-1.5 rounded-xl transition shadow-3xs">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-id-card text-slate-500"></i> Driving License
                                        </span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-slate-400 text-[9px]"></i>
                                    </a>
                                @else
                                    <span class="text-[10px] text-red-500 italic font-semibold flex items-center gap-1">
                                        <i class="fa-solid fa-circle-exclamation"></i> Driving License Not Provided
                                    </span>
                                @endif

                                @if($addr->sales_tax_permit)
                                    <a href="{{ asset($addr->sales_tax_permit) }}" target="_blank" 
                                       class="inline-flex items-center justify-between bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold px-3 py-1.5 rounded-xl transition shadow-3xs">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-file-invoice-dollar text-slate-500"></i> Sales Tax Permit
                                        </span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-slate-400 text-[9px]"></i>
                                    </a>
                                @else
                                    <span class="text-[10px] text-red-500 italic font-semibold flex items-center gap-1">
                                        <i class="fa-solid fa-circle-exclamation"></i> Sales Tax Permit Not Provided
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
