<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_locations', function (Blueprint $table) {
            $table->id();
            $table->float('latitud',16, 14);
            $table->float('longitud', 16, 14);
            $table->foreignId('addr_id')->unique();
            $table->timestamps();

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
        Schema::dropIfExists('geo_locations');
    }
}
