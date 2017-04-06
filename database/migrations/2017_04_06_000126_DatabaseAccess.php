<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('databases', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');

          $table->string('driver')->default('mysql');
          $table->string('host');
          $table->string('port')->default('mysql');
          $table->string('database');
          $table->string('username');
          $table->string('password', 100);

          $table->string('table');
          $table->string('uid_column');
          $table->string('student_type');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
