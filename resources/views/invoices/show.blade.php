<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Page
        </h2>
    </x-slot>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with PayPal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .paypal-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .paypal-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #343a40;
        }

        .paypal-logo img {
            width: 150px;
            margin-bottom: 20px;
        }

        .paypal-description {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .paypal-button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-transform: uppercase;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .paypal-button:hover {
            background-color: #0056b3;
            cursor: pointer;
        }

        .paypal-footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="paypal-container">
        <!-- PayPal Header -->
        <div class="paypal-header">Complete Your Payment</div>

        <!-- PayPal Logo -->
        <div class="paypal-logo">
            <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="PayPal">
        </div>

        <!-- Payment Description -->
        <div class="paypal-description">
            You are about to pay <strong>${{ number_format($invoice->amount, 2) }}</strong> for Invoice <strong>{{ $invoice->invoice_number }}</strong>.
        </div>

        <!-- PayPal Button -->
        <form action="{{ route('paypal.payment') }}" method="POST">
            @csrf
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
            <button type="submit" class="paypal-button">Pay with PayPal</button>
        </form>

        <!-- Footer Note -->
        <div class="paypal-footer">
            Safe and secure payment through PayPal.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    </x-app-layout>
