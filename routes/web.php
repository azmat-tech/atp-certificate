<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramEnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\NotificationController;



// Certificate Verification Routes
Route::get('/certificate-verification', [CertificateController::class, 'showVerificationPage'])->name('certificate.verification');
Route::post('/certificate-verification', [CertificateController::class, 'verifyCertificate'])->name('certificate.verify');
Route::get('/certificate/{certificate_no}', [CertificateController::class, 'showCertificate'])->name('certificate.show');

// Generate Certificate Route
Route::get('/certificate/{student}/generate', [StudentController::class, 'generateCertificate'])->name('certificate.generate');

// PayPal Payment Routes
Route::middleware('auth')->group(function () {
    Route::post('/paypal/payment', [PayPalController::class, 'processPayment'])->name('paypal.payment');
    Route::get('/paypal/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.success');
    Route::get('/paypal/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.cancel');
    
});

// Program Enrollment Routes
Route::middleware('auth')->group(function () {
    Route::get('/program/new/enrollments', [ProgramEnrollmentController::class, 'index'])->name('program-enrollments.index');
    Route::post('/program-enrollment', [ProgramEnrollmentController::class, 'store'])->name('program-enrollment.store');
    Route::get('/new/program', function () {
        return view('indexform');
    })->name('program.form');
    Route::middleware(['auth'])->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    });
});

// Student Routes
Route::middleware('auth')->group(function () {
    Route::get('/new/student/add', function () {
        return view('student.create');
    })->name('student.create');
    Route::get('/student/{program_code}', [StudentController::class, 'index'])->name('student.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/create/{program_code}', [StudentController::class, 'create'])->name('student.create');
    Route::get('/certificate/{student}', [CertificateController::class, 'generate'])->name('certificate.generate');
});

// Invoice Routes
Route::middleware('auth')->group(function () {
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
});

// Protected Dashboard Route
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/certificate/{id}', [CertificateController::class, 'show'])->name('certificate.show');



// Public Routes
Route::get('/', function () {
    return view('auth.login');
});
