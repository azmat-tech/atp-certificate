<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal;

class PayPalController extends Controller
{
    public function processPayment(Request $request)
    {
        // Retrieve the invoice
        $invoice = Invoice::findOrFail($request->invoice_id);

        // Configure PayPal
        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Create the PayPal order
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $invoice->amount,
                    ],
                ],
            ],
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
        ]);

        // Redirect to PayPal for approval
        if (isset($response['id']) && $response['status'] === 'CREATED') {
            $approveLink = collect($response['links'])->where('rel', 'approve')->first();
            return redirect($approveLink['href']);
        }

        return redirect()->back()->with('error', 'Unable to process PayPal payment.');
    }
    public function paymentSuccess(Request $request)
{
    // Configure PayPal
    $provider = new PayPal();
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    // Capture the payment
    $response = $provider->capturePaymentOrder($request->token);

    if (isset($response['status']) && $response['status'] === 'COMPLETED') {
        // Find the invoice by session_id
        $sessionId = $response['purchase_units'][0]['reference_id'];
        $invoice = Invoice::where('session_id', $sessionId)->firstOrFail();

        // Update the invoice status
        $invoice->update(['payment_status' => 'Paid']);

        return redirect()->route('invoices.show', $invoice->id)
                         ->with('success', 'Payment completed successfully!');
    }

    return redirect()->route('invoices.show', $invoice->id)
                     ->with('error', 'Payment failed.');
}
public function paymentCancel()
{
    return redirect()->route('invoices.index')
                     ->with('error', 'Payment was canceled.');
}

}
