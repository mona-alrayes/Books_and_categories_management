<?php

namespace App\Http\Requests\CategoryRequest;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateCategoryRequest extends CategoryServiceRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return parent::rules();
    }
}
