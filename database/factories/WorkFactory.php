<?php

namespace Database\Factories;

use App\Models\Work;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Work::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_start' => $this->faker->date,
            'date_end' => $this->faker->date,
            'hours' => $this->faker->randomNumber(2),
            'cost' => $this->faker->randomNumber(2),
            'client_id' => \App\Models\Client::factory(),
            'product_id' => \App\Models\Product::factory(),
            'statu_id' => \App\Models\Status::factory(),
        ];
    }
}
