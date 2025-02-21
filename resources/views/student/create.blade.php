<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .remove-btn {
            color: red;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800">Student Enrollment</h1>
    </x-slot>
    <div class="form-container">
        <div id="alert-container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <!-- Program Details -->
        <div class="form-section">
            <p><strong>Program Enrollment Number:</strong> {{ $programEnrollment->program_en_no ?? 'N/A' }}</p>
            <p><strong>Program Title:</strong> {{ $programEnrollment->program_title ?? 'N/A' }}</p>
            <p><strong>ALP Name:</strong> {{ $programEnrollment->alp_name ?? 'N/A' }}</p>
            <p><strong>ALP Number:</strong> {{ $programEnrollment->alp_number ?? 'N/A' }}</p>
            <p><strong>Program Start Date:</strong> {{ $programEnrollment->start_date ?? 'N/A' }}</p>
            <p><strong>Program End Date:</strong> {{ $programEnrollment->end_date ?? 'N/A' }}</p>
        </div>

        <form id="studentForm" action="{{ route('students.store') }}" method="POST">
            @csrf
            <div id="studentsWrapper">
                <!-- Student Form Row -->
                <div class="student-row">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="students[0][first_name]" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="students[0][surname]" class="form-control" placeholder="Surname" required>
                        </div>
                        <div class="col-md-6 mt-3">
                            <input type="email" name="students[0][email]" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-6 mt-3">
                            <input type="date" name="students[0][dob]" class="form-control" placeholder="Date of Birth" required>
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="number" name="students[0][assessment_marks1]" class="form-control" placeholder="Assessment Marks 1" required>
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="number" name="students[0][assessment_marks2]" class="form-control" placeholder="Assessment Marks 2" required>
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="number" name="students[0][total]" class="form-control" placeholder="Total" readonly>
                        </div>
                        <div class="col-md-6 mt-3">
                            <input type="text" name="students[0][pass]" class="form-control" placeholder="Pass/Fail" value="Pass" required>
                        </div>
                        <div class="col-md-12 mt-3 text-end">
                            <span class="remove-btn" style="display: none;">Remove</span>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <input type="hidden" name="program_code" value="{{ $programEnrollment->program_code }}">
            <button type="button" id="addMore" class="btn btn-success">+ Add More</button>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let studentIndex = 1;

        // Function to calculate total
        function calculateTotal(row) {
            const marks1 = row.querySelector('input[name*="[assessment_marks1]"]').value || 0;
            const marks2 = row.querySelector('input[name*="[assessment_marks2]"]').value || 0;
            const totalField = row.querySelector('input[name*="[total]"]');
            totalField.value = parseInt(marks1) + parseInt(marks2);
        }

        // Add event listeners to calculate total
        function addCalculationListeners(row) {
            const marks1Field = row.querySelector('input[name*="[assessment_marks1]"]');
            const marks2Field = row.querySelector('input[name*="[assessment_marks2]"]');

            marks1Field.addEventListener('input', () => calculateTotal(row));
            marks2Field.addEventListener('input', () => calculateTotal(row));
        }

        // Add remove functionality
        function addRemoveListener(row) {
            const removeBtn = row.querySelector('.remove-btn');
            removeBtn.style.display = 'inline'; // Show remove button
            removeBtn.addEventListener('click', function () {
                row.remove();
            });
        }

        // Add more students dynamically
        document.getElementById('addMore').addEventListener('click', function () {
            const wrapper = document.getElementById('studentsWrapper');
            const newRow = document.querySelector('.student-row').cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${studentIndex}]`);
                input.value = ''; // Clear input value
            });

            const removeBtn = newRow.querySelector('.remove-btn');
            removeBtn.style.display = 'inline'; // Show the remove button for new rows

            wrapper.appendChild(newRow);

            // Add calculation and remove listeners for the new row
            addCalculationListeners(newRow);
            addRemoveListener(newRow);

            studentIndex++;
        });

        // Initial row calculation listeners
        document.querySelectorAll('.student-row').forEach(row => {
            addCalculationListeners(row);
            addRemoveListener(row);
        });
    });
</script>
</body>
</html>
