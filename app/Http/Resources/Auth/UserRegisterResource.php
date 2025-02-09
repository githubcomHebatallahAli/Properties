<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;

use App\Http\Resources\MediaResource;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRegisterResource extends JsonResource
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
            'firstName'=>$this->firstName,
            'lastName'=>$this->lastName,
            'email'=>$this->email,
            'phoNum' => $this -> phoNum ,
            'governorate' => $this -> governorate,
            'center' => $this -> center,
            'address' => $this -> address,
            'userType' => $this -> userType,
        ];
    }
}
