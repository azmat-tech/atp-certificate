
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            margin-top: 50px;
        }
        .dashboard-card {
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .card-programs {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
        }
        .card-invoices {
            background: linear-gradient(135deg, #28a745, #1d8131);
            color: white;
        }
        .card-students {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: white;
        }
        .card-pending {
            background: linear-gradient(135deg, #dc3545, #a71c2d);
            color: white;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            border-radius: 8px;
        }
        .header h1 {
            font-size: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="header mb-4">
            <h1>Welcome to Your Dashboard</h1>
            <p>Here are your stats, {{ Auth::user()->name }}.</p>
        </div>
        <div class="row gy-4">
            <!-- Total Programs -->
            <div class="col-md-4">
                <div class="dashboard-card card-programs">
                    <h2>{{ $totalPrograms }}</h2>
                    <p>Total Programs</p>
                </div>
            </div>

            <!-- Total Invoices -->
            <div class="col-md-4">
                <div class="dashboard-card card-invoices">
                    <h2>{{ $totalInvoices }}</h2>
                    <p>Total Invoices</p>
                </div>
            </div>

            <!-- Paid Invoices -->
            <div class="col-md-4">
                <div class="dashboard-card card-invoices">
                    <h2>{{ $paidInvoices }}</h2>
                    <p>Paid Invoices</p>
                </div>
            </div>

            <!-- Unpaid Invoices -->
            <div class="col-md-4">
                <div class="dashboard-card card-pending">
                    <h2>{{ $unpaidInvoices }}</h2>
                    <p>Unpaid Invoices</p>
                </div>
            </div>

            <!-- Students with Marks -->
            <div class="col-md-4">
                <div class="dashboard-card card-students">
                    <h2>{{ $studentsWithMarks }}</h2>
                    <p>Students with Uploaded Marks</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</x-app-layout>
