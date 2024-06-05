<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuizRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mark' => 'required',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'questions' => 'required|array|min:1',
            'questions.*.title' => 'required|string|max:255',
            'questions.*.description' => 'nullable|string',
            'questions.*.mark' => 'required',
            'questions.*.choices' => 'required|array|min:2',
            'questions.*.choices.*.title' => 'required|string|max:255',
            'questions.*.choices.*.is_correct' => 'required',
            'questions.*.choices.*.order' => 'required|integer',
            'questions.*.choices.*.description' => 'nullable|string',
            'questions.*.choices.*.explanation' => 'nullable|string',
        ];
    }
}
