<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Request;

class RequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'circuit_id' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'circuit_speed' => $this->faker->numberBetween(-10000, 10000),
            'request_status' => $this->faker->word(),
            'token' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
