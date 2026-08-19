@extends('layouts.admin')

@section('header_title', 'Create Banner')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <h3 class="font-serif font-bold text-slate-800 text-lg">Add New Banner</h3>
        <a href="{{ route('admin.banners.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Banners</span>
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

    <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Title -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Banner Title</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Elevate Your Aura"
                   class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
        </div>

        <!-- Subtitle -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Banner Subtitle</label>
            <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="e.g. 100% charcoal-free, pure cow dung..."
                   class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
        </div>

        <!-- Link URL -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Link URL</label>
            <input type="text" name="link" value="{{ old('link') }}" placeholder="e.g. /shop"
                   class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Type Placement -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Placement Type *</label>
                <select name="type" required class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                    <option value="hero" @selected(old('type') === 'hero')>Hero Main Banner</option>
                    <option value="promo" @selected(old('type') === 'promo')>Promo Section</option>
                    <option value="sidebar" @selected(old('type') === 'sidebar')>Sidebar Banner</option>
                </select>
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

        <!-- Banner Image -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Banner Image File *</label>
            <input type="file" name="image" required accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#C49A6C]/10 file:text-[#C49A6C] hover:file:bg-[#C49A6C]/20 file:cursor-pointer">
            <span class="text-[10px] text-slate-450 block mt-1">Recommended for Hero: 1920x800px. Max size 3MB. JPG, PNG, WEBP.</span>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.banners.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-250 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Save Banner
            </button>
        </div>
    </form>

</div>
@endsection
