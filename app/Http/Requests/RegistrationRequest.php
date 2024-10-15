<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
    public function rules()
    {
        return [
            'nid' => 'required|unique:users,nid|min_digits:10',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'vaccine_center_id' => 'required|exists:vaccine_centers,id',
        ];
    }

    public function messages()
    {
        return [
            'nid.required' => 'NID is required. Please enter your valid NID number.',
            'nid.unique' => 'This NID is already registered. You can check your vaccine registration status.',
            'nid.min_digits' => 'The NID number must contain at least 10 digits.',
            'email.email' => 'Please enter a valid email format (e.g., name@example.com).',
            'email.unique' => 'This email address is already registered.',
            'vaccine_center_id.required' => 'Please select a vaccine center.',
            'vaccine_center_id.exists' => 'The selected vaccine center is invalid. Please choose a valid one.',
        ];
    }
}
