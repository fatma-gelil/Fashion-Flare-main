<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
           return[
               'full_name' => ['required', 'string', 'min:6', 'max:255'],
               'nickname' => ['required', 'string', 'max:255'],
               'phone_number' => ['required', 'numeric', 'digits:13'],
               'age' => ['required', 'numeric', 'integer', 'min:1', 'max:150'],
               'gender' => ['required', 'string', 'in:male,female'],
               'country' => ['required', 'string', 'max:255'],
               'address' => ['required', 'string', 'max:255'],
               'height' => ['required', 'numeric', 'between:0.01,99999.99'],
               'width' => ['required', 'numeric', 'between:0.01,99999.99'],
               'shoulder' => ['nullable', 'numeric', 'between:0.01,99999.99'],
               'chest' => ['nullable', 'numeric', 'between:0.01,99999.99'],
               'waist' => ['nullable', 'numeric', 'between:0.01,99999.99'],
               'hips' => ['nullable', 'numeric', 'between:0.01,99999.99'],
               'thigh' => ['nullable', 'numeric', 'between:0.01,99999.99'],
               'inseam' => ['nullable', 'numeric', 'between:0.01,99999.99'],
               'style'=>['required','string'],
               'fav_brand'=>['required','string']




           ];
    }
    public function messages()
    {
        return [
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',

            'nickname.required' => 'The nickname field is required.',
            'nickname.string' => 'The nickname must be a string.',
            'nickname.max' => 'The nickname may not be greater than :max characters.',
        ];
    }
}
