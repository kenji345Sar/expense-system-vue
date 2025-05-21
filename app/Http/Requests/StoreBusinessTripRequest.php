<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:1000',
            'details' => 'required|array',
            'details.*.business_trip_date' => 'required|date',
            'details.*.departure' => 'required|string|max:255',
            'details.*.destination' => 'required|string|max:255',
            'details.*.purpose' => 'nullable|string|max:255',
            'details.*.amount' => 'required|integer',
            'details.*.remarks' => 'nullable|string',
        ];
    }
}
