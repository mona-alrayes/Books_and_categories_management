<?php

namespace App\Http\Requests\BookRequest;


use Illuminate\Contracts\Validation\ValidationRule;

class StoreBookRequest extends BookServiceRequest
{
    /**
     * Additional or overridden rules for storing a book.
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return parent::rules();
    }
}
