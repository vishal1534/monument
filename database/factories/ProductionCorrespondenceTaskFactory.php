<?php

namespace Database\Factories;

use App\Models\CorrespondenceTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionCorrespondenceTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CorrespondenceTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'production_correspondence_task_date' => $this->faker->name,
        ];
    }
}
