<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuizToTableCatTypeQuiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_categorys', function (Blueprint $table) {
            $table->string('lpk')->nullable();
        });
        Schema::table('quiz_types', function (Blueprint $table) {
            $table->string('lpk')->nullable();
        });
        Schema::table('quizs', function (Blueprint $table) {
            $table->string('lpk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_cat_type_quiz', function (Blueprint $table) {
            //
        });
    }
}
