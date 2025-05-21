<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplyRequest extends FormRequest
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
            'details.*.supply_date' => 'required|date',
            'details.*.item_name' => 'required|string|max:255',
            'details.*.quantity' => 'required|integer',
            'details.*.unit_price' => 'required|integer',
            'details.*.remarks' => 'nullable|string',
            'details.*.total_price' => ['required', 'numeric'],
        ];
    }
}
