<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'name' => $this->whenLoaded('user',function(){
                return $this->user->name;
            }),
            'email' => $this->whenLoaded('user',function(){
                return $this->user->email;
            }),

            'status' => $this->status,
            'price' => $this->price,
            'phone' => $this->phone,
            'address' => $this->address,

            'specialization' => $this->whenLoaded('specialization',function(){
                return $this->specialization->name;
            }),
            'specialization_id' => $this->whenLoaded('specialization',function(){
                return $this->specialization->id;
            }),

            'clinic' => $this->whenLoaded('clinic',function(){
                return $this->clinic->name;
            }),
            'clinic_id' => $this->whenLoaded('clinic',function(){
                return $this->clinic->id;
            }),

            'days' => $this->whenLoaded('appointments', function () {
                return $this->appointments->pluck('day');
            }),

            'updated_at' => (new Carbon($this->updated_at))->format('Y-m-d'),
        ];
    }
}
