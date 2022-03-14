<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = Category::all();
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(50),
//            'stock_date'  => Carbon::create('2000','10','5'),
//            'stock_date'  => new Carbon($this->faker->dateTimeBetween('-3 years', '-3 days')), // Stocked between 3 years ago and now.

        ];
    }
}
