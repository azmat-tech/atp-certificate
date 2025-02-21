<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 7)->index(); // 7-digit unique session ID
            $table->string('first_name');
            $table->string('surname');
            $table->string('email');
            $table->date('dob');
            $table->integer('assessment_marks1');
            $table->integer('assessment_marks2');
            $table->integer('total');
            $table->string('pass');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
