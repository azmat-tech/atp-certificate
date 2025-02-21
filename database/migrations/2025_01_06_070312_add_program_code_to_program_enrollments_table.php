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
    Schema::table('program_enrollments', function (Blueprint $table) {
        $table->string('program_code')->unique()->after('program_en_no');
    });
}

public function down()
{
    Schema::table('program_enrollments', function (Blueprint $table) {
        $table->dropColumn('program_code');
    });
}

};
