<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'html' => $this->faker->randomHtml,
            'enable' => $this->faker->numberBetween(0, 127),
            'preview' => $this->faker->text,
        ];
    }
}
