<?php

namespace App\Http\Requests\User;

use App\Enums\User\Roles;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * This class represents the form request for updating a user.
 */
class UpdateRequest extends FormRequest
{
    /**
     * Indicates whether the validator should stop on the first validation failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'password' => 'string|min:8',
            'role' => ['string', new Enum(Roles::class)],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the custom messages for the validator.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Name must be in text format.',
            'name.max' => 'Name must have up to 255 characters.',
            'email.string' => 'Email must be in text format.',
            'email.email' => 'Provide a valid email.',
            'email.max' => 'Email must have up to 255 characters.',
            'email.unique' => 'This email is already in use. Try another.',
            'password.string' => 'Your password must contain letters and numbers.',
            'password.min' => 'Your password must have 8 or more characters.',
            'role.string' => 'Invalid role.',
        ];
    }
}
