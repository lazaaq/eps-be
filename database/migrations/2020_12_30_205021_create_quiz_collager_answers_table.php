<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizCollagerAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_collager_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('quiz_collager_id');
			$table->unsignedInteger('question_id');
			$table->string('collager_answer')->nullable();
			$table->boolean('isTrue');
			$table->tinyInteger('score');
            $table->timestamps();

            $table->foreign('quiz_collager_id')->references('id')->on('quiz_collagers');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_collager_answers');
    }
}
