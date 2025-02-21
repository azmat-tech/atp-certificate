<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramEnrollment;
use App\Models\Invoice;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user's ID
        $userId = Auth::id();

        // Fetch user-specific data
        $totalPrograms = ProgramEnrollment::where('user_id', $userId)->count();
        $totalInvoices = Invoice::where('user_id', $userId)->count();
        $paidInvoices = Invoice::where('user_id', $userId)->where('payment_status', 'Paid')->count();
        $unpaidInvoices = Invoice::where('user_id', $userId)->where('payment_status', '!=', 'Paid')->count();
        $studentsWithMarks = Student::where('user_id', $userId)->whereNotNull('assessment_marks1')->count();

        // Pass data to the view
        return view('dashboard', compact(
            'totalPrograms',
            'totalInvoices',
            'paidInvoices',
            'unpaidInvoices',
            'studentsWithMarks'
        ));
    }
}
