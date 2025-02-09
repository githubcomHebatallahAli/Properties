<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SelectedPropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this-> id,
            'mainImage' => $this -> mainImage,
            'property_name' => $this->property_name,
            'governorate' => $this->governorate,
            'totalPrice' => $this->totalPrice,
        ];
    }
}
