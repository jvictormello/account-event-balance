<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'type' => 'required|string|in:deposit,withdraw,transfer',
            'amount' => 'required|numeric|min:0.01',
            'destination' => 'required_if:type,deposit,transfer',
            'origin' => 'required_if:type,withdraw,transfer',
        ];
    }
}
