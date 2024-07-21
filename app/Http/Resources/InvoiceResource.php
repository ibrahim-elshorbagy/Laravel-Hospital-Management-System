<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
            'id' => $this->id,
            'patient_name' => $this->patient_name,
            'total_before_discount' => $this->total_before_discount,
            'discount_value' => $this->discount_value,
            'total_after_discount' => $this->total_after_discount,
            'tax_rate' => $this->tax_rate,
            'total_with_tax' => $this->total_with_tax,
            'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
