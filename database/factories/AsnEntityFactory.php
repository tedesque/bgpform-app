<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AsnEntity;
use App\Models\BgpRequest;

class AsnEntityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AsnEntity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'parent_id' => AsnEntity::factory(),
            'bgp_request_id' => BgpRequest::factory(),
            'asn' => $this->faker->randomNumber(),
            'as_set' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'tech_name1' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'tech_phone1' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'tech_mail1' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'asn_entity_id' => AsnEntity::factory(),
        ];
    }
}
