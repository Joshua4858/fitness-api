<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assuming all users are authorized
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exercise' => 'required|string|max:255',
            'sets' => 'required|integer|min:1',
            'reps' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:0',
        ];
    }

    /**
     * Customize the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'exercise.required' => 'The exercise name is required.',
            'sets.required' => 'The number of sets is required.',
            'sets.integer' => 'The number of sets must be an integer.',
            'sets.min' => 'The number of sets must be at least 1.',
            'reps.required' => 'The number of reps is required.',
            'reps.integer' => 'The number of reps must be an integer.',
            'reps.min' => 'The number of reps must be at least 1.',
            'weight.required' => 'The weight is required.',
            'weight.numeric' => 'The weight must be a valid number.',
            'weight.min' => 'The weight cannot be negative.',
        ];
    }
}
