<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Workout;

class WorkoutControllerTest extends TestCase
{

    /** @test */
    public function it_can_list_all_workouts()
    {
        // Create test data
        $workouts = Workout::factory()->count(3)->create();

        // Make a GET request to the API endpoint
        $response = $this->getJson('/api/workouts');

        // Assert the response status
        $response->assertStatus(200);

        // Assert that the response contains the expected fields
        $response->assertJsonStructure([
            '*' => [
                'exercise',
                'sets',
                'reps',
                'weight',
            ],
        ]);
    }

}
