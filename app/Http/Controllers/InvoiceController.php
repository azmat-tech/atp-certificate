<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }
    public function index()
    {
        // Fetch invoices only for the authenticated user
        $userId = Auth::id(); // Get the currently authenticated user's ID

        $invoices = Invoice::where('user_id', $userId)->paginate(10); // Adjust pagination as needed

        return view('invoices.index', compact('invoices'));
    }
}
