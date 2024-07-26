<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyPatientResource extends JsonResource
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
            'patient_name' => $this->name,
            'pivot_id' => $this->pivot->id,
            'daily_patient_index' => $this->pivot->daily_patient_index,
            'status' => $this->pivot->status,
            'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
