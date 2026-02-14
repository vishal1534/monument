<?php

namespace Database\Factories;

use App\Models\CollaborationTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionCollaborationTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CollaborationTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'production_collaboration_task_date' => $this->faker->name,
        ];
    }
}
