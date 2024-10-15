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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'nid' => 'required|unique:users,nid',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'vaccine_center_id' => 'required|exists:vaccine_centers,id',
        ];
    }
}
