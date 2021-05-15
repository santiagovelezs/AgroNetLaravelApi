<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'producer_id'=>2,
            'addr_id'=>1,
            'fecha'=>'2021/11/29',
            'hora'=>'13:00',
            'duracion'=>2,
            'title'=> 'Agro market',
            'desc' => null           
        ]);

        DB::table('events')->insert([
            'producer_id'=>2,
            'addr_id'=>2,
            'fecha'=>'2021/10/29',
            'hora'=>'13:00',
            'duracion'=>5,
            'title'=> 'Del Campo',
            'desc' => 'Vamos con nuestros mejores productos a un gran precio'            
        ]);

        DB::table('events')->insert([
            'producer_id'=>2,
            'addr_id'=>3,
            'fecha'=>'2021/09/29',
            'hora'=>'13:00',
            'duracion'=>4,
            'title'=> 'Mercado Campesino',
            'desc' => 'Aprovecha Solo este fin de semana'            
        ]);

        DB::table('events')->insert([
            'producer_id'=>2,
            'addr_id'=>4,
            'fecha'=>'2021/08/29',
            'hora'=>'13:00',
            'duracion'=>5,
            'title'=> 'Feria de las frutas',
            'desc' => null            
        ]);

        DB::table('events')->insert([
            'producer_id'=>3,
            'addr_id'=>5,
            'fecha'=>'2021/08/25',
            'hora'=>'13:00',
            'duracion'=>1,
            'title'=> 'Platanada',
            'desc' => null            
        ]);

        DB::table('events')->insert([
            'producer_id'=>3,
            'addr_id'=>6,
            'fecha'=>'2021/10/20',
            'hora'=>'13:00',
            'duracion'=>6,    
            'title'=> 'MercoCampo',
            'desc' => null        
        ]);

        DB::table('events')->insert([
            'producer_id'=>3,
            'addr_id'=>7,
            'fecha'=>'2021/09/14',
            'hora'=>'13:00',
            'duracion'=>3,
            'title'=> 'Mercado avicola',
            'desc' => null
        ]);
    }
}
