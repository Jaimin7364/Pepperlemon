@extends('layouts.admin')

@section('header_title', 'Registered Customers')

@section('content')
<div class="space-y-6">
    <!-- Search and Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-4 rounded-2xl border border-slate-100 shadow-xs">
        <form method="GET" action="{{ route('admin.users.index') }}" class="relative flex-1 max-w-md w-full">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customer name, email or phone..."
                   class="w-full bg-slate-50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-semibold text-slate-800 shadow-3xs focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
        </form>
        @if(request()->filled('search'))
            <a href="{{ route('admin.users.index') }}" class="text-xs text-red-500 hover:text-red-700 font-bold transition">
                Clear Filters
            </a>
        @endif
    </div>

    <!-- Customers Listing Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-bold text-slate-450 tracking-wider">
                        <th class="py-4 px-6">Name</th>
                        <th class="py-4 px-6">Email Address</th>
                        <th class="py-4 px-6">Contact Number</th>
                        <th class="py-4 px-6">Registered Date</th>
                        <th class="py-4 px-6">Addresses Count</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-tr from-[#C49A6C] to-[#b0875b] text-white h-8 w-8 rounded-full flex items-center justify-center font-extrabold text-xs shadow-3xs select-none">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">{{ $user->email }}</td>
                            <td class="py-4 px-6 font-semibold">{{ $user->phone ?? 'N/A' }}</td>
                            <td class="py-4 px-6 text-slate-450">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="py-4 px-6">
                                <span class="bg-slate-100 text-slate-650 text-[10px] font-extrabold px-2 py-0.5 rounded-full">
                                    {{ $user->addresses()->count() }} saved
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-150 text-[9px] font-extrabold uppercase px-2.5 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 border border-rose-150 text-[9px] font-extrabold uppercase px-2.5 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.users.toggleStatus', $user) }}" class="m-0" onsubmit="return confirm('Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} this customer\'s account?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 border rounded-xl px-2.5 py-1.5 font-bold transition shadow-3xs text-[10px] cursor-pointer {{ $user->is_active ? 'bg-rose-50 hover:bg-rose-100 border-rose-200 text-rose-700' : 'bg-emerald-50 hover:bg-emerald-100 border-emerald-200 text-emerald-700' }}">
                                            @if($user->is_active)
                                                <i class="fa-solid fa-user-slash text-[9px]"></i> Deactivate
                                            @else
                                                <i class="fa-solid fa-user-check text-[9px]"></i> Activate
                                            @endif
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="inline-flex items-center gap-1 bg-slate-50 hover:bg-[#C49A6C] hover:text-white border border-slate-200 rounded-xl px-3 py-1.5 font-bold transition shadow-3xs text-[10px] text-slate-700">
                                        <i class="fa-solid fa-eye text-[9px]"></i> View Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <i class="fa-solid fa-users-slash text-3xl mb-2 text-slate-200"></i>
                                <p class="text-xs font-semibold">No registered customers found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
