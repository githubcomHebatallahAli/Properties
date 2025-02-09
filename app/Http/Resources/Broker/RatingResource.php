<?php

namespace App\Http\Resources\Broker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\UserRegisterResource;
use App\Http\Resources\Auth\BrokerRegisterResource;

class RatingResource extends JsonResource
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
            'broker' => new BrokerRegisterResource($this->broker),
            'user' => new UserRegisterResource($this->user),
            'creationDate'=> $this-> creationDate,
            'rating'=> $this-> rating,
            'comment'=> $this-> comment,
            'transactionNum'=> $this-> transactionNum,
            'completeRate'=> $this-> completeRate,
        ];
    }
}
