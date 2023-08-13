<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'kana' => 'required|string|max:50',
            'tel' => 'numeric|unique:customers',
            'email' => 'email:rfc,dns',
            'postcode' => 'numeric',
            'address' => 'string',
            'birthday' => 'nullable',
            'gender' => 'numeric',
            'memo' => 'string|max:255|nullable',
        ];
    }
}
