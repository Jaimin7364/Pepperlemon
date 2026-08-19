@extends('layouts.admin')

@section('header_title', 'Manage Categories')

@section('content')
<div class="space-y-6">

    <!-- Actions Panel -->
    <div class="flex justify-end items-center bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
        <!-- Create Button -->
        <a href="{{ route('admin.categories.create') }}" class="w-full sm:w-auto text-center bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md shadow-[#C49A6C]/25 transition cursor-pointer flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Add Category</span>
        </a>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Name / Slug</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Products</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="h-12 w-12 rounded-xl object-cover bg-slate-50 border border-slate-100 p-0.5">
                                @else
                                    <div class="h-12 w-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-lg text-slate-450">
                                        📁
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-semibold text-slate-800">{{ $category->name }}</span>
                                <span class="block text-xs text-slate-400 mt-0.5">{{ $category->slug }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-sm truncate" title="{{ $category->description }}">
                                {{ $category->description ?: 'No description provided.' }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                {{ $category->products()->count() }} items
                            </td>
                            <td class="px-6 py-4">
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 bg-slate-100 hover:bg-[#C49A6C] hover:text-white rounded-lg text-slate-600 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Are you sure you want to delete this category? This will delete all products inside it!')">
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
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
