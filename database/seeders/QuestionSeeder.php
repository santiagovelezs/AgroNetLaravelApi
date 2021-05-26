<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('questions')->insert([
            'product_id'=>2,
            'user_id'=>1,
            "question"=>$faker->text($maxNbChars = 200),
        ]);

        DB::table('questions')->insert([
            'product_id'=>2,
            'user_id'=>2,
            "question"=>$faker->text($maxNbChars = 200),
        ]);

        DB::table('questions')->insert([
            'product_id'=>2,
            'user_id'=>1,
            "question"=>$faker->text($maxNbChars = 200),
        ]);

        DB::table('questions')->insert([
            'product_id'=>3,
            'user_id'=>1,
            "question"=>$faker->text($maxNbChars = 200),
        ]);
    }
}
