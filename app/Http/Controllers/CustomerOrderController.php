<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    // Display all customer orders
    public function index(Request $request)
    {
        $query = Order::where('user_id', Auth::id())->with(['items.product']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('order_number', 'like', '%' . $search . '%');
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('frontend.orders.index', compact('orders'));
    }

    // Submit return request
    public function requestReturn(Request $request, Order $order)
    {
        // Ensure order belongs to logged in user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Return is only allowed for completed orders that haven't been returned yet
        if ($order->status !== 'completed' || $order->return_status !== null) {
            return redirect()->back()->with('error', 'Return is not allowed for this order.');
        }

        $request->validate([
            'return_type'     => 'required|string|in:return,replace',
            'return_reason'   => 'required|string|max:255',
            'return_comments' => 'required|string|max:1000',
            'refund_account_details' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status'          => 'processing', // Keep as processing or special state
            'return_type'     => $request->return_type,
            'return_reason'   => $request->return_reason,
            'return_comments' => $request->return_comments,
            'refund_account_details' => $request->return_type === 'return' ? $request->refund_account_details : null,
            'return_status'   => 'pending', // Pending admin approval
        ]);

        return redirect()->back()->with('success', 'Your return request has been submitted successfully. Admin will review it shortly.');
    }

    // Cancel order
    public function cancelOrder(Request $request, Order $order)
    {
        // Ensure order belongs to logged in user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation if status is pending
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        $request->validate([
            'refund_account_details' => 'nullable|string|max:1000',
        ]);

        // Restock products
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('quantity', $item->quantity);
            }
        }

        $order->update([
            'status' => 'cancelled',
            'notes' => $order->notes ? $order->notes . "\nCancelled by customer." : 'Cancelled by customer.',
            'refund_account_details' => $request->refund_account_details,
        ]);

        return redirect()->back()->with('success', 'Your order has been cancelled successfully.');
    }
}
