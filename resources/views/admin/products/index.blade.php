@extends('layouts.admin')

@section('header_title', 'Manage Products')

@section('content')
<div class="space-y-6">

    <!-- Actions Panel -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU..." 
                   class="w-full sm:w-64 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
            
            <select name="category_id" class="w-full sm:w-48 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition cursor-pointer">
                Filter
            </button>
            
            @if(request()->anyFilled(['search', 'category_id']))
                <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Clear</a>
            @endif
        </form>

        <!-- Create Button -->
        <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto text-center bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md shadow-[#C49A6C]/25 transition cursor-pointer flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Add Product</span>
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Name / SKU</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Badges</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-xl object-contain bg-slate-50 border border-slate-100 p-1 cursor-zoom-in hover:scale-110 transition-transform duration-200" onclick="openImageReview('{{ $product->primary_image_url }}')">
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-semibold text-slate-800 max-w-xs truncate" title="{{ $product->name }}">{{ $product->name }}</span>
                                <span class="block text-xs text-slate-400 mt-0.5">SKU: {{ $product->sku }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-600">{{ $product->category->name }}</td>
                            <td class="px-6 py-4">
                                @if($product->sale_price)
                                    <span class="block font-bold text-slate-900">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="block text-xs text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="font-bold text-slate-900">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold {{ $product->quantity <= 10 ? 'text-red-500 font-bold' : 'text-slate-700' }}">
                                    {{ $product->quantity }} units
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($product->is_featured)
                                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-amber-50 text-amber-700 rounded border border-amber-100">Featured</span>
                                    @endif
                                    @if($product->is_bestseller)
                                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-purple-50 text-purple-700 rounded border border-purple-100">Bestseller</span>
                                    @endif
                                    @if($product->deal_of_week)
                                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-blue-50 text-blue-700 rounded border border-blue-100">Deal</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-slate-100 hover:bg-[#C49A6C] hover:text-white rounded-lg text-slate-600 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete this product?')">
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
                            <td colspan="8" class="px-6 py-8 text-center text-slate-400 font-medium">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Image Review Modal -->
<div id="image-review-modal" class="fixed inset-0 z-[9999] hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300 opacity-0" onclick="closeImageReview()">
    <div class="relative max-w-4xl max-h-[85vh] w-full flex items-center justify-center" onclick="event.stopPropagation()">
        <!-- Close Button -->
        <button onclick="closeImageReview()" class="absolute -top-12 right-0 text-white/85 hover:text-white transition-colors h-10 w-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 cursor-pointer">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
        <!-- Modal Image -->
        <img id="ir-modal-image" src="" alt="Product Review" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl border border-white/10">
    </div>
</div>
@endsection

@push('scripts')
<script>
function openImageReview(src) {
    const modal = document.getElementById('image-review-modal');
    const modalImg = document.getElementById('ir-modal-image');
    if (modal && modalImg) {
        modalImg.src = src;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
        document.body.style.overflow = 'hidden'; // Lock body scroll
    }
}

function closeImageReview() {
    const modal = document.getElementById('image-review-modal');
    if (modal) {
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
        document.body.style.overflow = ''; // Restore body scroll
    }
}
</script>
@endpush
