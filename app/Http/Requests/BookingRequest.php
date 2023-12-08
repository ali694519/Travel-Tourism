<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'quantity' => 'required',
            'seat_number.*'=>'required',
            'first_name.*' => 'required|string|max:255',
            'last_name.*' => 'required|string|max:255',
            'father_name.*' => 'required|string|max:255',
            'mother_name.*' => 'required|string|max:255',
            'place_of_birth.*' => 'required|string|max:255',
            'date_of_place.*' => 'required|date',
            'national_id.*' => 'required|string|max:255',
            'card_image_front.*' => 'required|image|mimes:jpeg,png,jpg,gif',
            'card_image_back.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
