<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'image' => mt_rand(10 ** 6, 10 ** 7 - 1) . '.jpg'
        ];
    }
}
