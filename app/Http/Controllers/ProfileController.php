<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('profile.index', compact('user', 'recentOrders'));
    }

    // Show order history
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems')
            ->latest()
            ->paginate(10);

        return view('profile.orders', compact('orders'));
    }

    // Show single order detail
    public function orderShow(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        $order->load('orderItems');

        return view('profile.order-detail', compact('order'));
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}
