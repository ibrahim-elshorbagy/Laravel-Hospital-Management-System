<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'patient_id'=>$this->whenLoaded('patient',function(){
                return $this->patient->id;
            }),
            'name'=>$this->name,
            'total_with_tax' => $this->whenLoaded('details',function(){
                return $this->details->total_with_tax;
            }),
            'created_at'=>(new Carbon($this->created_at))->format('Y-m-d'),
            'updated_at'=>(new Carbon($this->updated_at))->format('Y-m-d'),

        ];
    }
}
