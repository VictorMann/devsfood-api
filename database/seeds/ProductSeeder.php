<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::whereRaw('1=1')->truncate();

        foreach($this->getData() as $data)
        {
            Product::create($data);
        }
    }

    public function getData()
    {
        return [
            [
                "category_id"   => 1,
                "name"          => "Torta de Chocolate",
                "image"         => env("APP_URL") . "/images/tortachocolate.jpg",
                "price"         => 93,
                "ingredients"   => "algo, outro, tipo",
            ],
            [
                "category_id"   => 2,
                "name"          => "Donut de Flocos",
                "image"         => env("APP_URL") . "/images/donutflocos.jpg",
                "price"         => 0.8,
                "ingredients"   => "sal, frango",
            ],
            [
                "category_id"   => 1,
                "name"          => "Torta de Morango",
                "image"         => env("APP_URL") . "/images/tortamorango.jpg",
                "price"         => 128.12,
                "ingredients"   => null,
            ],
            [
                "category_id"   => 2,
                "name"          => "Donut de Chocolate",
                "image"         => env("APP_URL") . "/images/donutchocolate.jpg",
                "price"         => 1.5,
                "ingredients"   => "sal, frango",
            ],
        ];
    }
}
