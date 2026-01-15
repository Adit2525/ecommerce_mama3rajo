<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordChangeRequest;
use Illuminate\Http\Request;

class PasswordRequestController extends Controller
{
    /**
     * Display all password change requests.
     */
    public function index(Request $request)
    {
        $query = PasswordChangeRequest::with('user', 'approver');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default show pending first
            $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END");
        }

        $requests = $query->latest()->paginate(20);

        // Count pending requests for notification
        $pendingCount = PasswordChangeRequest::where('status', 'pending')->count();

        return view('admin.password-requests.index', compact('requests', 'pendingCount'));
    }

    /**
     * Approve password change request.
     */
    public function approve(PasswordChangeRequest $passwordRequest)
    {
        if (!$passwordRequest->isPending()) {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        // Update user's password
        $passwordRequest->user->update([
            'password' => $passwordRequest->new_password_hash,
        ]);

        // Update request status
        $passwordRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah untuk ' . $passwordRequest->user->name);
    }

    /**
     * Reject password change request.
     */
    public function reject(Request $request, PasswordChangeRequest $passwordRequest)
    {
        if (!$passwordRequest->isPending()) {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $passwordRequest->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Permintaan perubahan password ditolak.');
    }
}
