<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner' => $this->faker->text(255),
            'phone' => $this->faker->phoneNumber,
            'name' => $this->faker->name,
            'website' => $this->faker->text(250),
            'logo' => $this->faker->text(250),
            'direction' => $this->faker->text,
            'cost_hour' => $this->faker->randomNumber(2),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
