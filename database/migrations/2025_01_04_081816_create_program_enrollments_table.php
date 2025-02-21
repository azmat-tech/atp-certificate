<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::create('program_enrollments', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('program_title');
            $table->string('program');
            $table->string('alp_name');
            $table->string('alp_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('trainer_name');
            $table->string('program_en_no')->unique(); // 6-digit unique number
            $table->timestamps(); // For created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_enrollments');
    }
}
