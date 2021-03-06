<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producer_id');
            $table->foreignId('question_id');
            $table->string('answer',400);
            $table->timestamps();

            $table->foreign('question_id')
            ->references('id')->on('questions')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('producer_id')
            ->references('id')->on('producers')
            ->onUpdate('cascade')
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
        Schema::dropIfExists('answers');
    }
}
