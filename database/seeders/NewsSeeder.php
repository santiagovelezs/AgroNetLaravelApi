<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->insert([
            'producer_id'=>1,
            'title'=>'Nuevos Productos',
            'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean dapibus massa purus, sed lacinia nisi eleifend at.'            
        ]);

        DB::table('news')->insert([
            'producer_id'=>1,
            'title'=>'Nuevos Productos 2',
            'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean dapibus massa purus, sed lacinia nisi eleifend at.'            
        ]);

        DB::table('news')->insert([
            'producer_id'=>1,
            'title'=>'Nuevos Productos 3',
            'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean dapibus massa purus, sed lacinia nisi eleifend at.'            
        ]);

        DB::table('news')->insert([
            'producer_id'=>2,
            'title'=>'Nuevos Productos',
            'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean dapibus massa purus, sed lacinia nisi eleifend at.'            
        ]);
    }
}
