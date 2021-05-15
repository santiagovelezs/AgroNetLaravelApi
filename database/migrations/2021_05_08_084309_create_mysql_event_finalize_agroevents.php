<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMysqlEventFinalizeAgroevents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $state = ['cancelado', 'terminado'];
        
        //STARTS '00:00:00'
        DB::unprepared('CREATE EVENT IF NOT EXISTS finalize_events
                        ON SCHEDULE EVERY 1 DAY
                        DO
                            UPDATE events SET state = '.$state[1].'
                            WHERE state !=  '.$state[1].'
                            AND NOW() > fecha;'
                    );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finalize_events');
    }
}
