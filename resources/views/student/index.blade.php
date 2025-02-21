<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Enrollment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800">Program Detail</h1>
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-12">
                <div class="table-container mt-4">
                    <h1 class="text-center text-uppercase text-danger mb-4" style="font-size:40px;font-weight:600;">
                        {{ $programEnrollment->program_title }}
                    </h1>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Program Enrollment</th>
                                <td>{{ $programEnrollment->program_en_no }}</td>
                                <th>Program Title</th>
                                <td>{{ $programEnrollment->program_title }}</td>
                            </tr>
                            <tr>
                                <th>ALP Name</th>
                                <td>{{ $programEnrollment->alp_name }}</td>
                                <th>ALP No</th>
                                <td>{{ $programEnrollment->alp_number }}</td>
                            </tr>
                            <tr>
                                <th>Program Start Date</th>
                                <td>{{ $programEnrollment->start_date }}</td>
                                <th>Program End Date</th>
                                <td>{{ $programEnrollment->end_date }}</td>
                            </tr>
                            <tr>
                                <th>Submitted Date</th>
                                <td>{{ $programEnrollment->created_at->format('Y-m-d') }}</td>
                                <th>Invoice Paid Date</th>
                                <td>{{ $programEnrollment->updated_at->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <th>Total Students</th>
                                <td colspan="3">{{ $students->count() }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped">
                        <thead class="table-danger">
                            <tr>
                                <th>CERTIFICATE NO.</th>
                                <th>STUDENT</th>
                                <th>ASSESSMENT 1</th>
                                <th>ASSESSMENT 2</th>
                                <th>MARKS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->certificate_no }}</td>
                                    <td>{{ $student->first_name }} {{ $student->surname }}</td>
                                    <td>{{ $student->assessment_marks1 }}</td>
                                    <td>{{ $student->assessment_marks2 }}</td>
                                    <td>{{ $student->total }}</td>
                                    <td class="select-all">
                                        <input type="checkbox">
                                    </td>
                                 <td>
                                    @if ($programEnrollment->invoice && $programEnrollment->invoice->payment_status === 'Paid')
                                        <a href="{{ route('certificate.generate', $student->id) }}" class="btn btn-print btn-sm">Print</a>
                                    @else
                                        <button class="btn btn-print btn-sm" disabled>Print</button>
                                    @endif
                                </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
