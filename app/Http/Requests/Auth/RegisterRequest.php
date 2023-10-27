<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class RegisterRequest
 */
class RegisterRequest extends FormRequest
{
    /**
     * @var bool Stop validation on the first failure.
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool Always returns true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> The validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator The validator instance.
     *
     * @throws HttpResponseException Throws a HTTP response exception with a JSON payload containing the validation errors.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string> The error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Enter your name.',
            'name.string' => 'Name must be in text format.',
            'name.max' => 'Name must have up to 255 characters.',
            'email.required' => 'Enter your email.',
            'email.string' => 'Email must be in text format.',
            'email.email' => 'Enter a valid email.',
            'email.max' => 'Email must have up to 255 characters.',
            'email.unique' => 'This email is already in use. Try another.',
            'password.required' => 'Enter your password.',
            'password.min' => 'Your password must have 8 or more characters.',

        ];
    }
}
