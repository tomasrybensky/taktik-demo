<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetRollerCoastersRequest extends FormRequest
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
            'themeParkId' => ['integer', 'exists:theme_parks,id'],
            'manufacturerId' => ['integer', 'exists:manufacturers,id'],
            'minSpeed' => ['numeric', 'min:0'],
            'maxSpeed' => ['numeric', 'min:0'],
            'minHeight' => ['numeric', 'min:0'],
            'maxHeight' => ['numeric', 'min:0'],
            'minLength' => ['numeric', 'min:0'],
            'maxLength' => ['numeric', 'min:0'],
            'minInversions' => ['integer', 'min:0'],
            'maxInversions' => ['integer', 'min:0'],
            'sortBy' => ['string', 'in:name,height,length,speed,inversions,rating'],
            'sortDirection' => ['string', 'in:asc,desc'],
            'groupBy' => ['string', 'in:theme_park_id,manufacturer_id'],
        ];
    }
}
