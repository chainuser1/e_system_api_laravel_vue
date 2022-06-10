<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // drop email column
            $table->dropColumn('email');
            // drop email_verified_at column
            $table->dropColumn('email_verified_at');
            // add username column
            $table->string('username')->unique();
            // add id or srn verified_at column
            $table->timestamp('id_or_srn_verified_at')->nullable();
            // add user_type column enum with 'student' as default value
            $table->enum('user_type', ['student', 'staff','instructor','admin'])->default('student');
            // add password_reset_token column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
