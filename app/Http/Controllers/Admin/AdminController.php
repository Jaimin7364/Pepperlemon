<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSales = Order::where('payment_status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalProducts = Product::count();
        $totalUsers = User::where('is_admin', false)->count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders'
        ));
    }

    public function settings()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.edit', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
