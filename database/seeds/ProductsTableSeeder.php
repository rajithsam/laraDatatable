<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $products = ['Google','Samsung', 'LG', 'Apple', 'Acer', 'Sony', 'Coca Cola','IBM','HCL','Microsoft',
                     'Redmi','Onida','Voltas','Whirlpool','Nokia','Hitachi','Yahoo','Puma','Mercedes','Toyota',
                    'Facebook','Twitter','Linkedin','Nike','Adidas','Nintendo','Hyndai','Nivea','Reebok'];

        $categories = ['Vehicles','Electronics','Social Media','Gaming','Apparals','Micelleneous'];


        foreach ($products as $product) 
        {
            App\Product::create([
                'name'        => $product,
                'category'    => $faker->randomElement($categories),
                'price'       => '$' . $faker->randomNumber(3),
                'description' => $faker->text($maxNbChars = 50) 
            ]);
        }
    }
}
