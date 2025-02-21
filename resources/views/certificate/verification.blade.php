<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2b1055, #7597de);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .verification-container {
            background: white;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <h1 class="mb-4">Certificate Verification</h1>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('certificate.verify') }}" method="POST">
            @csrf
            <label for="certificate_no" class="form-label">Enter Certificate Number:</label>
            <input type="text" id="certificate_no" name="certificate_no" class="form-control mb-3" placeholder="e.g., 12345678" required>
            <button type="submit" class="btn btn-primary w-100">Verify</button>
        </form>
    </div>
</body>
</html>
