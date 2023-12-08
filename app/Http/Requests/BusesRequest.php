<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusesRequest extends FormRequest
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
            'trip_id' => 'required|exists:trips,id',
            'row_count' => 'required|integer|min:1',
            'left_row_count' => 'required|integer|min:0',
            'right_row_count' => 'required|integer|min:0',
            'last_row_count' => 'required|integer|min:0',
            'reserved_seats_count' => 'required|integer|min:0',
        ];
    }
}
