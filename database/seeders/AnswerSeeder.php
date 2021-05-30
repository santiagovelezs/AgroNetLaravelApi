<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('answers')->insert([
            'producer_id'=>2,
            'question_id'=>1,
            "answer"=>$faker->text($maxNbChars = 200),
        ]);

        DB::table('answers')->insert([
            'producer_id'=>2,
            'question_id'=>2,
            "answer"=>$faker->text($maxNbChars = 200),
        ]);

        DB::table('answers')->insert([
            'producer_id'=>2,
            'question_id'=>3,
            "answer"=>$faker->text($maxNbChars = 200),
        ]);

        DB::table('answers')->insert([
            'producer_id'=>2,
            'question_id'=>4,
            "answer"=>$faker->text($maxNbChars = 200),
        ]);

        DB::table('answers')->insert([
            'producer_id'=>3,
            'question_id'=>5,
            "answer"=>$faker->text($maxNbChars = 200),
        ]);
    }
}
