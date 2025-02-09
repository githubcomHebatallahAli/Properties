<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use App\Http\Resources\MainResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\Admin\UserTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrokerRegisterResource extends JsonResource
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
            'name'=>$this->name,
            'email'=>$this->email,
            'phoNum' => $this -> phoNum ,
            'governorate' => $this -> governorate,
            'address' => $this -> address,
            'userType' => $this -> userType,
        ];

    }
}
