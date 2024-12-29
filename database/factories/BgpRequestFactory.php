<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\bgpRequest;

class BgpRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BgpRequest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'circuit_id' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'circuit_speed' => $this->faker->numberBetween(-10000, 10000),
            'request_status' => $this->faker->randomElement(["Pendente","Conclu\u00edda","Rejeitada"]),
            'token' => $this->faker->uuid(),
            'device' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'router_table' => $this->faker->randomElement(["full route","partial route","default route"]),
            'asn' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
