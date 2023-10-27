<?php

namespace App\Http\Requests\Task\Type;

use App\Enums\Task\TypeStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

/**
 * This class represents the form request for creating a task type.
 */
class CreateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'status' => ['string', new Enum(TypeStatus::class)],
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
            'name.required' => 'Provide the name.',
            'name.string' => 'Name must be in text format.',
            'name.max' => 'Name must have up to 255 characters.',
            'status.string' => 'Invalid status.',
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        if (! isset($data['status'])) {
            $data['status'] = TypeStatus::Visible->value;
        }

        $this->merge($data);
    }
}
