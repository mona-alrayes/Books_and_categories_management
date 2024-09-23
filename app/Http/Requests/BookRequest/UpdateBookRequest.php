<?php

namespace App\Http\Requests\BookRequest;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateBookRequest extends BookServiceRequest
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
