<?php

namespace App\Http\Resources\Broker;

use Illuminate\Http\Request;
use App\Http\Resources\Broker\PropertyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrokerPropertiesResource extends JsonResource
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
            'name' => $this->name,
            'photo' => $this->photo,
            'propertiesCount' => $this->propertiesCount,
            'properties' => $this->getProperties(),
        ];
    }

    private function getProperties()
    {
        return collect([])
            ->merge($this->flats)
            ->merge($this->villas)
            ->merge($this->shops)
            ->merge($this->lands)
            ->merge($this->offices)
            ->merge($this->chalets)
            ->merge($this->clinics)
            ->merge($this->houses)
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'mainImage' => $property->mainImage,
                    'address' => "{$property->governorate}, {$property->city}, {$property->district}, {$property->street}",
                    'creationDate' => $property->creationDate,
                    'sale' => $property->sale,
                    'status' => $property->status,
                    'totalPrice' => $property->totalPrice,
                ];
            });


    }
}
