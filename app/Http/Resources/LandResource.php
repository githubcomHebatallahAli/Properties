<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\UserRegisterResource;
use App\Http\Resources\Auth\AdminRegisterResource;
use App\Http\Resources\Auth\BrokerRegisterResource;

class LandResource extends JsonResource
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
            'broker' => new BrokerRegisterResource($this->broker),
            'user' => new UserRegisterResource($this->user),
            'admin' => new AdminRegisterResource($this->admin),
            'installment' => new MainResource($this->installment),
            'transaction'=> new MainResource($this->transaction),
            'property'=> new MainResource($this->property),
            'electricity'=> new MainResource($this->electricity),
            'water'=> new MainResource($this->water),
            'sale'=>$this-> sale,
            'governorate'=>$this-> governorate,
            'city'=>$this-> city,
            'district'=>$this-> district,
            'street'=>$this-> street,
            'locationGPS'=>$this-> locationGPS,
            'facade'=>$this-> facade,
            'propertyNum'=>$this-> propertyNum,
            'description'=>$this-> description,
            'area'=>$this-> area,
            'length' =>$this-> length,
            'width' =>$this-> width,
            'ownerType'=>$this-> ownerType,
            'creationDate'=>$this-> creationDate,
            'status'=>$this-> status,
            'totalPrice'=>$this-> totalPrice,
            'installmentPrice'=>$this-> installmentprice,
            'downPrice'=>$this-> downPrice,
            'rentPrice'=>$this-> rentPrice,
            // 'media' => MediaResource::collection($this->media),
            'mainImage' =>$this-> mainImage,
            'image' =>$this-> image,
            'video' =>$this-> video,
            'audio' =>$this-> audio,
        ];
    }
}
