<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Request;
use App\Models\Response;

class ResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Response::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'request_id' => Request::factory(),
            'device' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'router_table' => $this->faker->randomElement(["'full route'",""]),
            'asn' => $this->faker->numberBetween(-10000, 10000),
            'ipv4_prefix' => $this->faker->ipv4(),
            'ipv6_prefix' => $this->faker->ipv4(),
        ];
    }
}
