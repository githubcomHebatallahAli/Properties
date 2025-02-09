<?php

namespace App\Http\Resources\Broker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrokerProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avgRating = $this->ratings->avg('rating');
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phoNum' => $this -> phoNum ,
            'email'=> $this -> email,
            // 'governorate' => $this -> governorate,
            'targetPlace' => $this -> targetPlace,
            'userType' => $this -> userType,
            'commission' => $this -> commission,
            'brief' => $this -> brief,
            'realEstateType' => $this -> realEstateType,
            'photo' => $this -> photo,
            'locationGPS'=> $this-> locationGPS,
            'avg_rating' => number_format(round($avgRating, 1), 1),
            'ratingsCount' => $this->ratingsCount,
            'propertiesCount'=> $this-> propertiesCount,
            'ratings' => $this->ratings->map(function ($rating) {
                return [
                    'name' => $rating->user->name,
                    'photo' => $rating->user->photo,
                    'rating' => $rating->rating,
                    'comment' => $rating->comment,
                ];
            }),
        ];
    }
}
