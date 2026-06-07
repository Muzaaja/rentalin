<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [

        'name' => ['nullable','string','max:255'],

        'email' => [
            'required',
            'string',
            'email',
            'max:255',
        ],

        'first_name' => [
            'nullable',
            'string',
            'max:100'
        ],

        'last_name' => [
            'nullable',
            'string',
            'max:100'
        ],

        'phone' => [
            'nullable',
            'string',
            'max:20'
        ],

        'address' => [
            'nullable',
            'string'
        ],

        'city' => [
            'nullable',
            'string',
            'max:100'
        ],

        'province' => [
            'nullable',
            'string',
            'max:100'
        ],

        'postal_code' => [
            'nullable',
            'string',
            'max:20'
        ],

    ];
}

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
        ];
    }
}
