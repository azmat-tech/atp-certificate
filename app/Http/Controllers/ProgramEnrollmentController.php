<?php
namespace App\Http\Controllers;

use App\Models\ProgramEnrollment;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Student;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class ProgramEnrollmentController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Request received for program enrollment', $request->all());

            // Validation rules
            $request->validate([
                'program_title' => 'required|string|max:255',
                'program' => 'required|string|max:255',
                'alp_name' => 'required|string|max:255',
                'alp_number' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'trainer_name' => 'required|string|max:255',
            ]);

            Log::info('Validation passed');

            // Generate a unique program_en_no
            do {
                $programEnNo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (ProgramEnrollment::where('program_en_no', $programEnNo)->exists());

            // Generate a unique program_code
            do {
                $programCode = strtoupper(substr(uniqid('PROG'), 0, 10));
            } while (ProgramEnrollment::where('program_code', $programCode)->exists());

            // Save the enrollment data
            ProgramEnrollment::create([
                'program_title' => $request->program_title,
                'program' => $request->program,
                'alp_name' => $request->alp_name,
                'alp_number' => $request->alp_number,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'trainer_name' => $request->trainer_name,
                'program_en_no' => $programEnNo,
                'program_code' => $programCode,
                'user_id' => auth()->id(),
            ]);

            Log::info('Program enrollment saved successfully.');

            return redirect()->back()->with('success', 'Program enrollment created successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing program enrollment', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Failed to save program enrollment. Please try again.');
        }
    }

    public function index(Request $request)
    {
        $search = $request->get('search', '');

        // Filter enrollments for the authenticated user
        $programEnrollments = ProgramEnrollment::where('user_id', auth()->id())
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('program_en_no', 'LIKE', "%$search%")
                          ->orWhere('program', 'LIKE', "%$search%")
                          ->orWhere('alp_name', 'LIKE', "%$search%");
                });
            })
            ->paginate(10);

        return view('program-enrollments.index', compact('programEnrollments', 'search'));
    }
    
}