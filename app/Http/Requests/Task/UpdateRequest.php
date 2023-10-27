<?php

namespace App\Http\Requests\Task;

use App\Enums\Task\TaskStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:start_date',
            'start_date' => 'date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => [new Enum(TaskStatus::class)],
            'task_type_id' => 'uuid|exists:task_types,id',
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
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'deadline.date' => 'The deadline must be a valid date.',
            'deadline.after_or_equal' => 'The deadline must be a date equal to or after the start date.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be a date equal to or after the start date.',
            'status.in' => 'The status must be either pendding or done.',
            'task_type_id.uuid' => 'The task type ID must be a valid UUID.',
            'task_type_id.exists' => 'The specified task type ID does not exist.',
        ];
    }
}
