<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'account_type'=>['required','boolean'],
            'invoice_type'=>['required','string'],
            'selectedServices' => ['nullable', 'array'],
            'selectedServices.*.id' => ['exists:services,id'],
            // 'selectedServices.*.name' => ['string'],
            // 'selectedServices.*.price' => ['numeric'],

            'selectedPackages' => ['nullable', 'array'],
            'selectedPackages.*.id' => ['exists:packages,id'],
            // 'selectedPackages.*.name' => ['string'],
            // 'selectedPackages.*.price' => ['numeric'],

            'clinic' => ['nullable', 'exists:clinics,id'],

            'selectedDoctors' => ['nullable', 'array'],
            'selectedDoctors.*.id' => ['exists:doctors,id'],
            // 'selectedDoctors.*.name' => ['string'],
            // 'selectedDoctors.*.price' => ['numeric'],


            'total_before_discount' => ['required', 'numeric', 'max:99999999.99'],
            'discount_value' => ['required', 'numeric', 'max:99999999.99'],
            'total_after_discount' => ['required', 'numeric', 'max:99999999.99'],
            'tax_rate' => ['required', 'numeric'],
            'total_with_tax' => ['required', 'numeric', 'max:99999999.99'],

            'patient.id' => ['nullable', 'exists:patients,id'],
            'patient.name' => ['required', 'string'],
            'patient.email' => ['nullable', 'email', 'unique:users,email'],

            'is_paid'=>['required','boolean'],
        ];

    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->validationData();

            if (empty($data['selectedServices']) && empty($data['selectedPackages']) && empty($data['selectedDoctors'])) {
                $validator->errors()->add('type', 'please select Invoice Type With Details');
            }
        });
    }

}
