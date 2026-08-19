<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->is_admin) {
            abort(404);
        }

        $user->load('addresses');
        return view('admin.users.show', compact('user'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->is_admin) {
            abort(403);
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Customer account has been {$status} successfully.");
    }
}
