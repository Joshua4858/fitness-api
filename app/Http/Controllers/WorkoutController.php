<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkoutRequest;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

/**
 * Handles workout-related operations.
 */
class WorkoutController extends Controller
{
    /**
     * Display a list of all workouts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        return response()->json(Workout::all());
    }

    /**
     * Store a newly created workout in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WorkoutRequest $request) : JsonResponse
    {
        // Check request for validated data.
        $validatedData = $request->validated();
        // Add user id to the workout data.
        $validatedData['user_id'] = auth()->id();
        // Create the workout
        $workout = Workout::create($validatedData);

        // Return success response
        return response()->json($workout, 201);
    }

    /**
     * Display the specified workout by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) : JsonReponse
    {
        $workout = Workout::findOrFail($id);

        return response()->json($workout);
    }

    /**
     * Update the specified workout in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(WorkoutRequest $request, Workout $workout)
    {
        // if(! Gate::allows('update-workout', $workout)) {
        //     return $this->errorResponse('Forbidden to do that!', 403);
        // }
        //Gate::authorize('update-workout', $workout);

        $validatedData = $request->validated();

        $workout->update($validatedData);

        return response()->json($workout, 200);
    }

    /**
     * Remove the specified workout from the database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Workout $workout)
    {
        $workout->delete();

        return response()->json(null, 204);
    }
}
