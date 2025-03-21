<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
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
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20', 'regex:/^\+?[1-9]\d{1,14}$/'],
            'customer_email' => ['required', 'email', 'max:255'],
            'room_ids' => ['required', 'array', 'min:1'],
            'room_ids.*' => ['integer', Rule::exists('rooms', 'id')],
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'status' => ['sometimes', Rule::in(['pending', 'confirmed', 'canceled'])],
        ];
    }
}
