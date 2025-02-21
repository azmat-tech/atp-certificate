<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Enrollments</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            max-width: 1200px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800">Program Enrollments</h1>
    </x-slot>

    <div class="table-container">
    <div style="dislay:flex;margin:40px 0px;">   
        <h3 style="width:47%;display:inline-block;">Program Enrollments</h3>
        <button style="width:47%;display:inline-block;text-align:end;"><a href="/new/program" style="background:black;padding:12px 30px;border-radius:10px;color:white;">Add New Program</a></button>


   
    </div>
        
        <!-- Search Bar -->
        <form method="GET" action="{{ route('program-enrollments.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Enrollment Number, Title, or ALP" value="{{ $search }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- Table -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Program Enrollment No.</th>
                    <th>Program</th>
                    <th>Start Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programEnrollments as $index => $enrollment)
                <tr>
                    <td>{{ $loop->iteration + ($programEnrollments->currentPage() - 1) * $programEnrollments->perPage() }}</td>
                    <td>{{ $enrollment->program_en_no }}</td>
                    <td>{{ $enrollment->program }}</td>
                    <td>{{ $enrollment->start_date }}</td>
                    <td>
                        Marks: 
                        <strong>
                            @php
                                $hasStudents = \App\Models\Student::where('program_code', $enrollment->program_code)->exists();
                            @endphp
                            {{ $hasStudents ? 'Uploaded' : 'Not Uploaded' }}
                        </strong><br>
                        Invoice: 
                        <strong>
                            {{ $enrollment->invoice_status === 'Paid' ? 'Paid' : 'Not Paid' }}
                        </strong>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </button>
                        <ul class="dropdown-menu">
                            @if ($hasStudents)
                                <li><a class="dropdown-item" href="{{ route('student.index', $enrollment->program_code) }}">View</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('student.create', $enrollment->program_code) }}">Upload Marks</a></li>
                            @endif
                        </ul>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">No Program Enrollments Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $programEnrollments->appends(['search' => $search])->links() }}
        </div>
    </div>
</x-app-layout>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
