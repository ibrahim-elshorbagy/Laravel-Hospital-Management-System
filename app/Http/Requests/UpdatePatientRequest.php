<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
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
        $userId = $this->route("patient.user_id");

        return [
            'email' => ['required','email',Rule::unique('users')->ignore($userId),],
            'password' => ['nullable', 'string', 'min:8'],
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }
}
