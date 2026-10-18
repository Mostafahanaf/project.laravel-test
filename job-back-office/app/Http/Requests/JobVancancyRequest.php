<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVancancyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:companies,name,' . $this->route('companies'),
            'location'  => 'required|string|max:255',
            'salary' => 'required|string|min:0',
            'type' => 'required|string|max:255',
            'description'  => 'nullable|string|max:255',
            'categoryId' => 'required|string|max:255',
            'companyId' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title has already been taken.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'salary.required' => 'The salary field is required.',
            'salary.string' => 'The salary must be a string.',
            'salary.min' => 'The salary must be a positive value.',
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a string.',
            'type.max' => 'The type may not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'categoryId.required' => 'The job category field is required.',
            'categoryId.string' => 'The job category must be a string.',
            'categoryId.max' => 'The job category may not be greater than 255 characters.',
            'companyId.required' => 'The company field is required.',
            'companyId.string' => 'The company must be a string.',
            'companyId.max' => 'The company may not be greater than 255 characters.',


        ];
    }
}
