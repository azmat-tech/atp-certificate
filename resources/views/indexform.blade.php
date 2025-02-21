<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Enrollment Form</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #trainer_section{
            display:none;
        }
        .form-container {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-custom {
            background-color: #17a2b8;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #138496;
        }
        .section-header {
            margin-top: 20px;
            font-size: 1.2rem;
            color: #6c757d;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
    <h1 >Program Enrollment</h1>

    </x-slot>
    
    <div class="form-container">
        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif  
        <form id="programForm" action="{{ route('program-enrollment.store') }}" method="POST">
       @csrf
            <!-- Program Details -->
            <div class="mb-3">
                <label for="programTitle" class="form-label">Program Title</label>
                <input type="text" id="programTitle" name="program_title" class="form-control" placeholder="Enter Program Title">
            </div>
            <div class="mb-3">
                <label for="program" class="form-label">Program</label>
                <select id="program" name="program" class="form-select">
                    <option selected disabled>Select Program</option>
                    <option value="Program1">Program 1</option>
                    <option value="Program2">Program 2</option>
                    <!-- Add more options here -->
                </select>
            </div>
            <div class="mb-3">
                <label for="alpName" class="form-label">ALP Name</label>
                <input type="text" id="alpName" name="alp_name" class="form-control" value="{{ Auth::user() ? Auth::user()->name : '' }}" readonly>
                </div>
            <div class="mb-3">
                <label for="alpNumber" class="form-label">ALP Number</label>
                <input type="text" id="alpNumber" name="alp_number" class="form-control" value=" {{ Auth::user()->alp_number }}" readonly>
            </div>
            <div class="mb-3">
                <label for="startDate" class="form-label">Program Start Date</label>
                <input type="date" id="startDate" name="start_date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">Program End Date</label>
                <input type="date" id="endDate" name="end_date" class="form-control">
            </div>

            <!-- Trainer Information -->
        <div id="trainer_section">
            <div class="section-header">3. Trainer Info</div>
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="trainerSurname" class="form-label">Surname</label>
                    <input type="text" id="trainerSurname" class="form-control" placeholder="Jon">
                </div>
                <div class="col-md-4">
                    <label for="trainerForename" class="form-label">Forename</label>
                    <input type="text" id="trainerForename" class="form-control" placeholder="Smith">
                </div>
                <div class="col-md-4">
                    <label for="trainerEmail" class="form-label">Email</label>
                    <input type="email" id="trainerEmail" class="form-control" placeholder="example@email.com">
                </div>
            </div>
            <button type="button" class="btn btn-custom mt-3" id="saveTrainerButton">Save New Trainer</button>
    </div>
            <!-- Trainer Dropdown -->
            <div class="mt-4">
                <label for="trainerSelect" class="form-label">Trainer Name</label>
                <select id="trainerSelect" name="trainer_name" class="form-select">
                    <option selected disabled>Select Trainer</option>
                    <option value="Shan Ali">Shan Ali</option>
                </select>
                <button type="button" class="btn btn-primary mt-3" id="addTrainerButton">Add New Trainer</button>
            </div>

            <!-- Submit and Cancel -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</x-app-layout>


    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const saveTrainerButton = document.getElementById('saveTrainerButton');
            const trainerSelect = document.getElementById('trainerSelect');

            // Save New Trainer
            saveTrainerButton.addEventListener('click', () => {
                const surname = document.getElementById('trainerSurname').value.trim();
                const forename = document.getElementById('trainerForename').value.trim();
                const email = document.getElementById('trainerEmail').value.trim();

                if (surname && forename && email) {
                    const fullName = `${forename} ${surname}`;

                    // Add new trainer to the dropdown
                    const newOption = document.createElement('option');
                    newOption.value = fullName;
                    newOption.textContent = `${fullName} (${email})`;
                    trainerSelect.appendChild(newOption);

                    // Reset fields after saving
                    document.getElementById('trainerSurname').value = '';
                    document.getElementById('trainerForename').value = '';
                    document.getElementById('trainerEmail').value = '';

                    alert('Trainer added successfully!');
                } else {
                    alert('Please fill in all fields to add a new trainer.');
                }
            });
        });
        jQuery(document).ready(function(){
            jQuery('#saveTrainerButton').click(function(){
             jQuery('#trainer_section').slideUp();
            });
        });

        jQuery(document).ready(function(){
            jQuery('#addTrainerButton').click(function(){
             jQuery('#trainer_section').slideDown();
            });
        });


    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>
</html>
