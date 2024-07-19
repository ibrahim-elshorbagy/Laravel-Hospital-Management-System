<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'selectedServices' => ['required', 'array', 'min:1'],
            'total_before_discount' => ['required', 'numeric'],
            'discount_value' => ['required', 'numeric'],
            'total_after_discount' => ['required', 'numeric'],
            'tax_rate' => ['required', 'numeric'],
            'total_with_tax' => ['required', 'numeric'],
        ];
    }
}
