<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\BgpRequest;
use App\Models\Prefix;

class PrefixFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prefix::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ip_prefix' => $this->faker->ipv4(),
            'bgp_request_id' => BgpRequest::factory(),
        ];
    }
}
