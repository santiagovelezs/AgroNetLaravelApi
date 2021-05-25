<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producer_id');
            $table->foreignId('category_id');
            $table->string('image_path');
            $table->string('name',40);
            $table->string('description',200);
            $table->integer('measurement');
            $table->float('price');
            $table->timestamps();

            $table->foreign('producer_id')
                ->references('id')->on('producers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
                $table->foreign('category_id')
                ->references('id')->on('categorys')
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
        Schema::dropIfExists('products');
    }
}
