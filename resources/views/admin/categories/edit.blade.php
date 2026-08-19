@extends('layouts.admin')

@section('header_title', 'Edit Category')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <h3 class="font-serif font-bold text-slate-800 text-lg">Edit Category: {{ $category->name }}</h3>
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Categories</span>
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

    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Category Name -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Category Name *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required placeholder="e.g. Sacred Dhoop Sticks"
                   class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
        </div>

        <!-- Description -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Description</label>
            <textarea name="description" rows="3" placeholder="Brief description of the collection..."
                      class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">{{ old('description', $category->description) }}</textarea>
        </div>

        <!-- Current Image -->
        @if($category->image)
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Current Image</label>
                <img src="{{ asset($category->image) }}" class="h-28 w-28 object-cover rounded-xl border border-slate-100 p-0.5">
            </div>
        @endif

        <!-- Category Image -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Upload New Image (Optional)</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#C49A6C]/10 file:text-[#C49A6C] hover:file:bg-[#C49A6C]/20 file:cursor-pointer">
            <span class="text-[10px] text-slate-450 block mt-1">Recommended size: 800x600px. JPG, PNG, WEBP.</span>
        </div>

        <!-- Status -->
        <label class="flex items-center space-x-3 cursor-pointer bg-slate-50 p-4 rounded-xl border border-slate-100">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))
                   class="rounded border-slate-350 text-[#C49A6C] focus:ring-[#C49A6C] h-4.5 w-4.5">
            <span class="text-sm font-semibold text-slate-700">Category Active</span>
        </label>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-250 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Update Category
            </button>
        </div>
    </form>

</div>
@endsection
