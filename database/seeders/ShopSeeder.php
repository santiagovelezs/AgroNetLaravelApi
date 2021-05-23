<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('shops')->insert([
            'producer_id'=>2,
            'whatsapp'=>'312345678',
            'phone'=>'8887777',
            'email'=>'platanera@mail.es',            
            'addr_id'=>11,
            'price_per_km'=>850,
            'max_shipping_distance'=>15
        ]);        
    }
}
