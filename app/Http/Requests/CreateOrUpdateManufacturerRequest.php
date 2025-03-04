<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateManufacturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string|max:1000',
            'website' => 'sometimes|nullable|url|max:255',
        ];
    }
}
