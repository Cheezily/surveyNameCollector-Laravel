<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('university_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::table('instructors', function (Blueprint $table) {
            $table->foreign('university_id')
                ->references('id')->on('universities')
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
        Schema::dropIfExists('instructors');
    }
}
