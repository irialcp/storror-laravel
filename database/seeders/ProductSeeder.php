<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => '101010 HOODIE',
                'color' => 'Grey',
                'price' => 88.95,
                'image' => 'public/H_101010_LightGrey_01.png',
                'image_hover' => 'public/H_101010_LightGrey_02.png',
                'in_stock' => true,
            ],
            [
                'name' => '101010 CREWNECK',
                'color' => 'Faded Black',
                'price' => 69.95,
                'image' => 'public/Crew_101010_GreyBlack_01.png',
                'image_hover' => 'public/Crew_101010_GreyBlack_02.png',
                'in_stock' => true,
            ],
            [
                'name' => '101010 T-SHIRT',
                'color' => 'Faded Black',
                'price' => 50.95,
                'image' => 'public/COMP_T_Graffiti_Black_01.png',
                'image_hover' => 'public/COMP_T_Graffiti_Black_02.png',
                'in_stock' => true,
            ],
            [
                'name' => 'GRAFFITI T-SHIRT',
                'color' => 'Faded Black',
                'price' => 50.95,
                'image' => 'public/T_Graffiti_GreyBlack_01.png',
                'image_hover' => 'public/T_Graffiti_GreyBlack_02.png',
                'in_stock' => true,
            ],
            [
                'name' => 'GRAFFITI T-SHIRT',
                'color' => 'Faded White',
                'price' => 44.95,
                'image' => 'public/T_Graffiti_White_01.png',
                'image_hover' => 'public/T_Graffiti_White_03.png',
                'in_stock' => true,
            ],
            [
                'name' => 'GRAFFITI ZIP-UP',
                'color' => 'Faded Black',
                'price' => 95.95,
                'image' => 'public/ZH_Graffiti_GreyBlack_01.png',
                'image_hover' => 'public/ZH_Graffiti_GreyBlack_02.png',
                'in_stock' => true,
            ],
            [
                'name' => 'GRAFFITI CREWNECK',
                'color' => 'Faded Grey',
                'price' => 63.95,
                'image' => 'public/Crew_Graffiti_WarmGrey_01.png',
                'image_hover' => 'public/QDggc.png',
                'in_stock' => true,
            ],
            [
                'name' => 'TECH TENS',
                'color' => 'Grey/Black',
                'price' => 171.95,
                'image' => 'public/Shoes_Grey_03.png',
                'image_hover' => 'public/Shoes_Grey_04.png',
                'in_stock' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}