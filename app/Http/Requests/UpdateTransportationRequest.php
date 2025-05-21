<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportationRequest extends FormRequest
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
            'description' => 'nullable|string|max:255',
            'details' => 'required|array|min:1',
            'details.*.use_date' => 'required|date',
            'details.*.departure' => 'required|string|max:100',
            'details.*.arrival' => 'required|string|max:100',
            'details.*.route' => 'nullable|string|max:255',
            'details.*.amount' => 'required|numeric|min:0',
            'details.*.remarks' => 'nullable|string|max:255',
        ];
    }
}
