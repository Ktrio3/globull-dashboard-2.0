<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttributeDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('attribute_database', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('database_id')->unsigned()->nullable();
          $table->foreign('database_id')->references('id')->on('databases')->onDelete('cascade');

          $table->integer('attribute_id')->unsigned()->nullable();
          $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');

          $table->string('column');
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
