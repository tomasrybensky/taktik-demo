<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRollerCoasterRequest extends FormRequest
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
            'manufacturer_id' => 'required|integer|exists:manufacturers,id',
            'theme_park_id' => 'required|integer|exists:theme_parks,id',
            'height' => 'sometimes|nullable|integer',
            'length' => 'sometimes|nullable|integer',
            'speed' => 'sometimes|nullable|integer',
            'inversions' => 'sometimes|nullable|integer',
        ];
    }
}
