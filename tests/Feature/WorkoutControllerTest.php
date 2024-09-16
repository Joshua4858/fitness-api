<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WorkoutControllerTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Set up an authenticated user before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user
        $this->user = User::factory()->create([
            'email_verified_at' => now(), // Simulate email verification
        ]);

        // Create a token for the user
        $this->token = $this->user->createToken('fitness-api')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$this->token);

    }

    #[Test]
    public function it_can_list_all_workouts()
    {
        // Create test data
        $workouts = Workout::factory()->count(2)->create();

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

    #[Test]
    public function it_can_store_workout()
    {
        $workout = Workout::factory()->make()->toArray();

        // Post request to endpoint
        $response = $this->postJson('/api/workouts/', $workout);

        $response->assertStatus(201);

        $this->assertDatabaseHas('workouts', $workout);
    }

    #[Test]
    public function it_can_update_workout()
    {
        $workout = Workout::factory()->create();

        $updateData = [
            'exercise' => 'Updated Exercise Name',
            'sets' => 4,
            'reps' => 10,
            'weight' => 100,
        ];

        // Update that workout in the database
        $response = $this->putJson('/api/workouts/'.$workout->id, $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('workouts', [
            'id' => $workout->id,
            'exercise' => 'Updated Exercise Name',
            'sets' => 4,
            'reps' => 10,
            'weight' => 100,
        ]);
    }

    #[Test]
    public function it_can_delete_workout()
    {
        $workout = Workout::factory()->create();

        // Delete after creating
        $response = $this->deleteJson('/api/workouts/'.$workout->id);

        // Asserting that the response status is 204 (No Content);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('workouts', ['id' => $workout->id]);
    }
}
