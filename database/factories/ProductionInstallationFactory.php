<?php

namespace Database\Factories;

use App\Models\ProductionInstallation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionInstallationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductionInstallation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'production_installation_who' => $this->faker->name,
        ];
    }
}
