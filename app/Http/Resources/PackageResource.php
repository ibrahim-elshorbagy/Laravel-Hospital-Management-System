<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
        public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'Total_before_discount' => $this->Total_before_discount,
            'discount_value' => $this->discount_value,
            'Total_after_discount' => $this->Total_after_discount,
            'tax_rate' => $this->tax_rate,
            'Total_with_tax' => $this->Total_with_tax,
            'status' => $this->status,
            'services' => $this->whenLoaded('services', function () {
                return $this->services->pluck('id');
            }),
            'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
            'updated_at' => (new Carbon($this->updated_at))->format('Y-m-d'),
        ];

    }
}
