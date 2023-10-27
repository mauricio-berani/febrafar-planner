<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class LoginRequest
 */
class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
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
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator The validator instance.
     *
     * @throws HttpResponseException Throws a HTTP response exception with a JSON payload containing the validation errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Enter your email.',
            'email.email' => 'Enter a valid email.',
            'email.exists' => 'The provided credentials are incorrect.',
            'password.required' => 'Enter your password.',
        ];
    }
}
