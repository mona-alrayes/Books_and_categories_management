<?php

namespace App\Http\Requests\CategoryRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Common validation rules.
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['string', 'min:3', 'max:255'],
            'description' => ['string', 'min:3', 'max:255'],
        ];

        if ($this->isMethod('post')) {
            // Required for store request
            $rules['name'][] = 'required';
            $rules['description'][] = 'nullable';

        } else if ($this->isMethod('put')) {
            // Allow optional fields for update request
            $rules['name'][] = 'sometimes';
            $rules['description'][] = 'nullable';

        }

        return $rules;
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب',
            'string' => 'حقل :attribute يجب أن يكون نصًا وليس أي نوع آخر',
            'max' => 'عدد محارف :attribute لا يجب أن يتجاوز 255 محرفًا',
            'min' => 'حقل :attribute يجب أن يكون 3 محارف على الأقل',
        ];
    }

    /**
     * Custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'name' => 'اسم التصنيف',
            'description' => 'الوصف',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => ucwords(strtolower($this->input('name'))),
            'description' => ucwords(strtolower($this->input('description'))),
        ]);
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'خطأ',
            'message' => 'فشلت عملية التحقق من صحة البيانات.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
