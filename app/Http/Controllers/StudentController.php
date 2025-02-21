<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ProgramEnrollment;
use App\Models\Invoice;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log incoming request data
            Log::info('Request Received', $request->all());
    
            // Validate the request
            $validated = $request->validate([
                'students' => 'required|array',
                'program_code' => 'required|exists:program_enrollments,program_code',
                'students.*.first_name' => 'required|string|max:255',
                'students.*.surname' => 'required|string|max:255',
                'students.*.email' => 'required|email|max:255',
                'students.*.dob' => 'required|date',
                'students.*.assessment_marks1' => 'required|integer',
                'students.*.assessment_marks2' => 'required|integer',
                'students.*.pass' => 'required|string|max:10',
            ]);
    
            // Generate a session ID for grouping students
            $sessionId = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
    
            foreach ($request->students as $studentData) {
                $studentData['session_id'] = $sessionId;
                $studentData['program_code'] = $request->program_code;
                $studentData['user_id'] = Auth::id();
                $studentData['total'] = $studentData['assessment_marks1'] + $studentData['assessment_marks2'];
    
                // Generate a unique 8-digit certificate number
                do {
                    $certificateNo = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
                } while (Student::where('certificate_no', $certificateNo)->exists());
    
                $studentData['certificate_no'] = $certificateNo;
    
                Log::info('Saving Student', $studentData);
    
                // Save each student
                $student = Student::create($studentData);
    
                if (!$student) {
                    throw new \Exception('Failed to save student.');
                }
            }
    
            // Create an invoice
            $invoice = Invoice::create([
                'user_id' => Auth::id(),
                'session_id' => $sessionId,
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'amount' => count($request->students) * 5,
                'payment_status' => 'Unpaid',
                'issued_date' => now(),
            ]);
    
            if (!$invoice) {
                throw new \Exception('Failed to generate invoice.');
            }
    
            Log::info('Invoice Created Successfully');
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Students and invoice saved successfully!');
        } catch (\Exception $e) {
            Log::error('Error in Store Method', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
    
            // Redirect with error message
            return redirect()->back()->with('error', 'An error occurred while saving the data.');
        }
    }
    
    public function create($program_code)
    {
        // Fetch program enrollment based on program_code
        $programEnrollment = ProgramEnrollment::where('program_code', $program_code)->first();

        if (!$programEnrollment) {
            Log::error("Program not found for code: {$program_code}");
            return redirect()->back()->with('error', 'Program not found.');
        }

        Log::info('Program Enrollment Data:', $programEnrollment->toArray());

        // Return the form view with program enrollment data
        return view('student.create', compact('programEnrollment'));
    }


    public function index($program_code)
{
    // Fetch the program enrollment along with its invoice
    $programEnrollment = ProgramEnrollment::with('invoice')
        ->where('program_code', $program_code)
        ->first();

    if (!$programEnrollment) {
        return redirect()->back()->with('error', 'Program not found.');
    }

    // Fetch all students associated with the program enrollment
    $students = Student::where('program_code', $program_code)->get();

    // Return a view with the data
    return view('student.index', compact('programEnrollment', 'students'));
}


public function generateCertificate(Student $student)
{
    $programEnrollment = ProgramEnrollment::with('invoice')
        ->where('program_code', $student->program_code)
        ->first();

    if (!$programEnrollment || !$programEnrollment->invoice || $programEnrollment->invoice->payment_status !== 'Paid') {
        return redirect()->back()->with('error', 'Invoice is not paid. Certificate cannot be generated.');
    }

    return view('certificate.show', compact('student', 'programEnrollment'));
}
    
}
