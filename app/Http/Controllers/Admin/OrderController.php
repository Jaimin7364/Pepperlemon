<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            if ($request->status === 'return_requested') {
                $query->where('return_status', 'pending');
            } elseif ($request->status === 'returned') {
                $query->where(function($q) {
                    $q->where('status', 'returned')
                      ->orWhere('return_status', 'approved');
                });
            } elseif ($request->status === 'return_rejected') {
                $query->where(function($q) {
                    $q->where('status', 'return_rejected')
                      ->orWhere('return_status', 'rejected');
                });
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('shipping_name', 'like', '%' . $request->search . '%')
                  ->orWhere('shipping_email', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'              => 'required|string|in:pending,processing,shipped,completed,cancelled,failed,returned,return_rejected',
            'payment_status'      => 'required|string|in:pending,completed,failed',
            'ups_tracking_number' => 'nullable|string|max:100',
            'return_status'       => 'nullable|string|in:pending,approved,rejected',
        ]);

        $status = $request->status;
        $returnStatus = $request->filled('return_status') ? $request->return_status : $order->return_status;

        // Auto-sync order status with return status updates
        if ($request->filled('return_status')) {
            if ($request->return_status === 'approved') {
                $status = 'returned';
            } elseif ($request->return_status === 'rejected') {
                $status = 'return_rejected';
            }
        }

        $order->update([
            'status'              => $status,
            'payment_status'      => $request->payment_status,
            'ups_tracking_number' => $request->ups_tracking_number,
            'return_status'       => $returnStatus,
        ]);

        return redirect()->back()->with('success', 'Order updated successfully.');
    }
}
