<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyInvoiceREsource extends JsonResource
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
        'invoice_type'=>$this->invoice_type,
        'total_with_tax' => $this->whenLoaded('details', function () {
            return $this->details->total_with_tax;
        }),
        'doctor' => $this->whenLoaded('doctors', function () {
            return $this->doctors->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => optional($doctor->user)->name,
                    'clinic' => optional($doctor->clinic)->name,
                    'daily_patient_index' => $doctor->pivot->daily_patient_index,
                ];
            });
        }),
        'services' => $this->whenLoaded('services', function () {
            return $this->services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => $service->price,
                    'daily_patient_index' => $service->pivot->daily_patient_index,
                ];
            });
        }),
        'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
    ];

    }
}
