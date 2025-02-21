<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class NotificationController extends Controller
{
    public function index()
    {
        // Fetch pending invoices for the logged-in user
        $pendingInvoices = Invoice::where('user_id', auth()->id())
            ->where('payment_status', '!=', 'Paid')
            ->where('notification_status', 0)
            ->get();

        return view('notifications.index', compact('pendingInvoices'));
    }

    public function markAsRead(Request $request)
    {
        // Mark notifications as read
        Invoice::where('user_id', auth()->id())
            ->where('notification_status', 0)
            ->update(['notification_status' => 1]);

        return redirect()->back()->with('success', 'Notifications marked as read.');
    }
}
