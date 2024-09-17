<?php

namespace Database\Factories;

use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    protected $model = Workout::class;

    public function definition()
    {
        return [
            'exercise' => $this->faker->word(),
            'sets' => $this->faker->numberBetween(1, 5),
            'reps' => $this->faker->numberBetween(1, 15),
            'weight' => $this->faker->numberBetween(50, 300),
        ];
    }
}
