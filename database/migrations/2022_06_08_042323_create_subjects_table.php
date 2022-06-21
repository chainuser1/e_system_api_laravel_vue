<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            // add the one who created the subject
            $table->unsignedBigInteger('user_id');
            // instructor assigned to the subject
            $table->string('instructor_id')->nullable();
            // make the user_id column as foreign key
            $table->foreign('user_id')->references('id')->on('users');
            // make instructor_id column as foreign key to users table
            // make instructor id a foreign key to membership number on users table
            // $table->foreign('instructor_id')->references('users')->on('membership_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
