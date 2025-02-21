<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifications
        </h2>
    </x-slot>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group mt-4">
        @forelse ($pendingInvoices as $invoice)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Invoice #{{ $invoice->invoice_number }} is still unpaid.</span>
                <span class="badge bg-warning">Pending</span>
            </li>
        @empty
            <li class="list-group-item text-center">No new notifications.</li>
        @endforelse
    </ul>

    @if ($pendingInvoices->count() > 0)
        <form method="POST" action="{{ route('notifications.markAsRead') }}" class="mt-3">
            @csrf
            <button class="btn btn-primary">Mark All as Read</button>
        </form>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</x-app-layout>
