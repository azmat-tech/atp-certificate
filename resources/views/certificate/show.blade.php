<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Certificate</h1>
        <div class="card">
            <div class="card-body">
                <h3>International Board of Safety Professionals</h3>
                <p>This certificate is awarded to:</p>
                <h2>{{ $student->first_name }} {{ $student->surname }}</h2>
                <p>For successfully completing the program: <strong>{{ $student->program_code }}</strong></p>
                <p>Certificate No: {{ $student->certificate_no }}</p>
                <p>Date of Issue: {{ now()->format('d M Y') }}</p>
            </div>
        </div>
        @if (auth()->check())
            <a href="#" class="btn btn-primary mt-3">Print Certificate</a>
        @endif
    </div>
</body>
</html>
