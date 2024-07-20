<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'phone' => $this->phone,
            'address' => $this->address,
            'updated_at' => (new Carbon($this->updated_at))->format('Y-m-d'),
        ];
    }
}
