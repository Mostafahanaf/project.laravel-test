<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:companies,name',
            'address'  => 'required|string|max:255',
            'industry' => 'required|string|max:255|in:Technology,Healthcare,Finance,Education,Retail,Manufacturing,Other',
            'website'  => 'nullable|url|max:255',

            //owner details
            'Owner_name' => 'required|string|max:255',
            'Owner_email' => 'required|string|email|max:255|unique:users,email',
            'Owner_password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.unique' => 'The name has already been taken.',
            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'industry.required' => 'The industry field is required.',
            'industry.string' => 'The industry must be a string.',
            'industry.max' => 'The industry may not be greater than 255 characters.',
            'website.string' => 'The website must be a string.',
            'website.url' => 'The website format is invalid.',
            'website.max' => 'The website may not be greater than 255 characters.',


            //owner details
            'Owner_name.required' => 'The owner name field is required.',
            'Owner_name.string' => 'The owner name must be a string.',
            'Owner_name.max' => 'The owner name may not be greater than 255 characters.',
            'Owner_email.required' => 'The owner email field is required.',
            'Owner_email.string' => 'The owner email must be a string.',
            'Owner_email.email' => 'The owner email must be a valid email address.',
            'Owner_email.max' => 'The owner email may not be greater than 255 characters.',
            'Owner_email.unique' => 'The owner email has already been taken.',
            'Owner_password.required' => 'The owner password field is required.',
            'Owner_password.string' => 'The owner password must be a string.',
            'Owner_password.min' => 'The owner password must be at least 8 characters.',
            'Owner_password.max' => 'The owner password may not be greater than 255 characters.',

        ];
    }
}
