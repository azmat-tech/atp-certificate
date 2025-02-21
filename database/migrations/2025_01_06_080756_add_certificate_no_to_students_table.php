<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('students', function (Blueprint $table) {
        $table->string('certificate_no', 8)->unique()->after('pass'); // Add unique constraint
    });
}

public function down()
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropColumn('certificate_no');
    });
}

};
