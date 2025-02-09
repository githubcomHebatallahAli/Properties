<?php

namespace App\Http\Resources\Broker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
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
            'mainImage' => $this->mainImage,
            'address' => "{$this->governorate}, {$this->city}, {$this->district}, {$this->street}",
            'creationDate' => $this->creationDate,
            'sale' => $this->sale,
            'status' => $this->status,
            'totalPrice' => $this->totalPrice,
        ];
    }
}
