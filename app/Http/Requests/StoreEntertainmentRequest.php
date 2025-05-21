<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntertainmentRequest extends FormRequest
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
            'details' => 'required|array|min:1',
            'details.*.entertainment_date' => 'required|date',
            'details.*.client_name' => 'required|string|max:100',
            'details.*.place' => 'required|string|max:100',
            'details.*.content' => 'nullable|string|max:255',
            'details.*.amount' => 'required|numeric|min:0',
        ];
    }
}
