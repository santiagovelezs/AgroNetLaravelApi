<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producer_id')->unique();
            $table->string('whatsapp', 20);
            $table->string('phone', 20);
            $table->string('email', 20)->unique();
            $table->foreignId('addr_id');
            $table->float('price_per_km');
            $table->float('max_shipping_distance');            
            $table->timestamps();

            $table->foreign('producer_id')
                ->references('id')->on('producers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('addr_id')
                ->references('id')->on('addrs')
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
        Schema::dropIfExists('shops');
    }
}
