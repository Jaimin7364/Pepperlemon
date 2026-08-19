<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'link' => 'nullable|string|max:255',
            'type' => 'required|string|in:hero,promo,sidebar',
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $path = public_path('uploads/banners');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $name = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($path, $name);
            $imagePath = 'uploads/banners/' . $name;
        }

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image_path' => $imagePath,
            'link' => $request->link,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'link' => 'nullable|string|max:255',
            'type' => 'required|string|in:hero,promo,sidebar',
        ]);

        $imagePath = $banner->image_path;
        if ($request->hasFile('image')) {
            $path = public_path('uploads/banners');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $name = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($path, $name);
            $imagePath = 'uploads/banners/' . $name;
        }

        $banner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image_path' => $imagePath,
            'link' => $request->link,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
