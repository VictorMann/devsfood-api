<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::whereRaw('1=1')->truncate();

        foreach ($this->getData() as $data)
        {
            Category::create($data);
        }
    }

    public function getData()
    {
        return [
            [
                "name"  => "Tortas",
                "image" => env('APP_URL') . '/images/cats/pie.png',
            ],
            [
                "name"  => "Donuts",
                "image" => env('APP_URL') . '/images/cats/donut.png',
            ],
            [
                "name"  => "Cookies",
                "image" => env('APP_URL') . '/images/cats/cookies.png',
            ],
        ];
    }
}
