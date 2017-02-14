<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnlinkStudentTypesAttributeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Student types no longer have attribute types.
        // Student types have attributes, which belong to a category.
        // This allows students to share attribute categories, but have different
        //    attributes in each category. (i.e. Transfer has different housing reqs.)
        Schema::table('attribute_types', function (Blueprint $table) {
            $table->dropForeign(['student_type_id']);

            $table->dropColumn('student_type_id');
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
