<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AsnEntity;
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
            'asn_entity_id' => AsnEntity::factory(),
        ];
    }
}
