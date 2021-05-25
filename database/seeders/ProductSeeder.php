<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('products')->insert([
            'producer_id'=>2,
            'category_id'=>1,
            "image_path"=>'https://www3.gobiernodecanarias.org/medusa/mediateca/ecoescuela/wp-content/uploads/sites/2/2013/11/15-Papa-ojo-rosado.png',
            "name"=>$faker->word(),
            "description"=>$faker->text($maxNbChars = 100),
            "measurement"=>1,
            "price"=>$faker->randomDigitNotNull()

        ]);
        DB::table('products')->insert([
            'producer_id'=>2,
            'category_id'=>1,
            "image_path"=>$faker->imageUrl($width = 640, $height = 480),
            "name"=>$faker->word(),
            "description"=>$faker->text($maxNbChars = 100),
            "measurement"=>1,
            "price"=>$faker->randomDigitNotNull()

        ]);
        DB::table('products')->insert([
            'producer_id'=>2,
            'category_id'=>1,
            "image_path"=>$faker->imageUrl($width = 640, $height = 480),
            "name"=>$faker->word(),
            "description"=>$faker->text($maxNbChars = 100),
            "measurement"=>1,
            "price"=>$faker->randomDigitNotNull()

        ]);
        DB::table('products')->insert([
            'producer_id'=>3,
            'category_id'=>1,
            "image_path"=>$faker->imageUrl($width = 640, $height = 480),
            "name"=>$faker->word(),
            "description"=>$faker->text($maxNbChars = 100),
            "measurement"=>1,
            "price"=>$faker->randomDigitNotNull()

        ]);
        DB::table('products')->insert([
            'producer_id'=>3,
            'category_id'=>1,
            "image_path"=>$faker->imageUrl($width = 640, $height = 480),
            "name"=>$faker->word(),
            "description"=>$faker->text($maxNbChars = 100),
            "measurement"=>1,
            "price"=>$faker->randomDigitNotNull()

        ]);
    }
}
