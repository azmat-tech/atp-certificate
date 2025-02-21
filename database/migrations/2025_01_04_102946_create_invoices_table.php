<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique()->index(); // Unique identifier for the session
            $table->string('invoice_number')->unique(); // Unique invoice number
            $table->decimal('amount', 10, 2); // Total amount of the invoice
            $table->string('payment_status')->default('Unpaid'); // 'Paid' or 'Unpaid'
            $table->timestamp('issued_date')->nullable(); // When the invoice was created
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
