<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'category_id'=> Category::query()->inRandomOrder('id'),
            'brand_id'=> Brand::query()->inRandomOrder('id'),
            'name'=> fake()->name,
            'slug'=> fake()->slug,
            'description'=> fake()->text,
            'image'=> fake()->image,
            'price'=> random_int(10000,99999),
            'quantity'=> random_int(10,99),

        ];
    }
}
