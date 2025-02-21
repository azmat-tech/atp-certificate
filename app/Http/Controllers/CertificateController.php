<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ProgramEnrollment;

class CertificateController extends Controller
{
    public function showVerificationPage()
    {
        return view('certificate.verification');
    }

    public function verifyCertificate(Request $request)
{
    $validated = $request->validate([
        'certificate_no' => 'required|digits:8', // Ensure the certificate number is 8 digits
    ]);

    $certificate = Student::where('certificate_no', $request->certificate_no)->first();

    if ($certificate) {
        // Redirect to the certificate page with the correct student ID
        return redirect()->route('certificate.show', ['id' => $certificate->id]);
    }

    // If not found, return with an error message
    return redirect()->back()->with('error', 'Certificate not found. Please check the certificate number and try again.');
}


    public function showCertificate($certificate_no)
    {
        // Fetch the student by certificate number
        $certificate = Student::where('certificate_no', $certificate_no)->firstOrFail();

        // Fetch the associated program enrollment
        $programEnrollment = ProgramEnrollment::where('program_code', $certificate->program_code)->first();

        // Ensure the program enrollment exists
        if (!$programEnrollment) {
            return redirect()->back()->with('error', 'Program Enrollment not found.');
        }

        // Pass both the student and program enrollment to the view
        return view('certificate.show', compact('certificate', 'programEnrollment'));
    }
    public function show($id)
{
    $student = Student::findOrFail($id);
    $programEnrollment = ProgramEnrollment::where('program_code', $student->program_code)->first();

    return view('certificate.show', compact('student', 'programEnrollment'));
}

}
