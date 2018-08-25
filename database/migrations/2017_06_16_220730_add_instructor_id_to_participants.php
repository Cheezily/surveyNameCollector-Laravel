<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInstructorIdToParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
          $table->integer('instructor_id')->unsigned();
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->foreign('instructor_id')
            ->references('id')->on('instructors')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
          $table->dropColumn('instructor_id');
        });
    }
}
