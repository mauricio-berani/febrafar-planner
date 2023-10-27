<?php

namespace App\Http\Requests\Common;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * The MatchRequest class handles the validation of incoming requests for matching operations.
 */
class MatchRequest extends FormRequest
{
    /**
     * @var bool To stop validation on the first failure.
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
            'search' => 'string|max:255',
            'perPage' => 'integer',
            'orderBy' => 'string',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator  The validator instance.
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string> The custom error messages.
     */
    public function messages(): array
    {
        return [
            'search.string' => 'Invalid search term.',
            'search.max' => 'Try searching for a shorter name.',
            'perPage.integer' => 'Invalid pagination parameters.',
            'orderBy.string' => 'Invalid sorting parameters.',
        ];
    }
}
