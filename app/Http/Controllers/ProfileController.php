<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PasswordChangeRequest;
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

        // Check if user has pending password change request
        $pendingPasswordRequest = PasswordChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        return view('profile.index', compact('user', 'recentOrders', 'pendingPasswordRequest'));
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

    // Request password change (requires admin verification)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        // Check if there's already a pending request
        $existingRequest = PasswordChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'Anda sudah memiliki permintaan perubahan password yang menunggu verifikasi admin.');
        }

        // Create password change request
        PasswordChangeRequest::create([
            'user_id' => $user->id,
            'new_password_hash' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan perubahan password telah dikirim. Menunggu verifikasi admin.');
    }

    // Cancel pending password change request
    public function cancelPasswordRequest()
    {
        $user = Auth::user();
        
        PasswordChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->delete();

        return back()->with('success', 'Permintaan perubahan password telah dibatalkan.');
    }
}

