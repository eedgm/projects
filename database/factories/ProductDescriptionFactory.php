<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductDescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDescriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDescription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->word,
            'product_id' => \App\Models\Product::factory(),
            'field_id' => \App\Models\Field::factory(),
        ];
    }
}
