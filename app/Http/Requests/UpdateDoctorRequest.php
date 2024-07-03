<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
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
        $userId = $this->route("doctor.user_id");

        return [
            'email' => ['required','email',Rule::unique('users')->ignore($userId),],
            'password' => ['nullable', 'string', 'min:8'],
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string', 'max:255'],
            'specialization_id' => ['required', 'exists:specializations,id'],
            'clinic_id' => ['required', 'exists:clinics,id'],
            'status' => ['required', 'string'],
            'price' => ['nullable', 'numeric'],
            'days' => ['nullable', 'array', 'min:1'],
            'days.*' => ['required_with:days', 'string', 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'],
        ];
    }
}
