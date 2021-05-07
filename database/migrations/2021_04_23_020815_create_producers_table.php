<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producers', function (Blueprint $table) {            
            $table->foreignId('id')->primary();
            $table->foreignId('sede_ppal')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id')
                ->references('id')->on('registered_users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('sede_ppal')
                ->references('id')->on('addrs')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producers');
    }
}
