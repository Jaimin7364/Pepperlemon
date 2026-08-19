<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku',
            'quantity' => 'required|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.001',
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            $path = public_path('uploads/products');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $ext = $file->getClientOriginalExtension() ?: 'jpg';
                    $name = time() . '_' . uniqid() . '.' . $ext;
                    $file->move($path, $name);
                    $imagePaths[] = 'uploads/products/' . $name;
                }
            }
        }

        if (empty($imagePaths)) {
            $imagePaths[] = 'images/premium_dhoop_product.png';
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sku' => $request->sku ?: 'VB-' . strtoupper(Str::random(6)),
            'quantity' => $request->quantity,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'is_bestseller' => $request->has('is_bestseller'),
            'deal_of_week' => $request->has('deal_of_week'),
            'is_active' => $request->has('is_active'),
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'images' => json_encode($imagePaths)
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'quantity' => 'required|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.001',
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $existingImages = json_decode($product->images, true) ?? [];

        // Handle removing checked images
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $removeImg) {
                if (str_starts_with($removeImg, 'uploads/products/')) {
                    $fullPath = public_path($removeImg);
                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                }
            }
            $existingImages = array_filter($existingImages, function($img) use ($request) {
                return !in_array($img, $request->remove_images);
            });
        }

        // Handle uploading new images
        if ($request->hasFile('images')) {
            $path = public_path('uploads/products');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $newImages = [];
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $ext = $file->getClientOriginalExtension() ?: 'jpg';
                    $name = time() . '_' . uniqid() . '.' . $ext;
                    $file->move($path, $name);
                    $newImages[] = 'uploads/products/' . $name;
                }
            }
            // Put newly uploaded images first so the new image reflects as primary immediately!
            $existingImages = array_merge($newImages, $existingImages);
        }

        // If all images removed, add the default fallback
        if (empty($existingImages)) {
            $existingImages[] = 'images/premium_dhoop_product.png';
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sku' => $request->sku ?: $product->sku,
            'quantity' => $request->quantity,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'is_bestseller' => $request->has('is_bestseller'),
            'deal_of_week' => $request->has('deal_of_week'),
            'is_active' => $request->has('is_active'),
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'images' => json_encode(array_values($existingImages))
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
