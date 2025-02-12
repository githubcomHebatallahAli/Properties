<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\Admin\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\UserRegisterResource;
use App\Http\Resources\Auth\AdminRegisterResource;

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
            'id'=>$this-> id,
            // 'broker' => new BrokerRegisterResource($this->broker),
            'category' => new CategoryResource($this->category),
            'user' => new UserRegisterResource($this->user),
            'admin' => new AdminRegisterResource($this->admin),
            'installment' => new MainResource($this->installment),
            'transaction'=> new MainResource($this->transaction),
            'finish'=> new MainResource($this->finish),
            'electricity'=> new MainResource($this->electricity),
            'water'=> new MainResource($this->water),
            'sale'=>$this->sale,
            'governorate'=>$this-> governorate,
            'city'=>$this-> city,
            'district'=>$this-> district,
            'street'=>$this-> street,
            'locationGPS'=>$this-> locationGPS,
            'facade'=>$this-> facade,
            'propertyNum'=>$this-> propertyNum,
            'description'=>$this-> description,
            'area'=>$this-> area,
            'ownerType'=>$this-> ownerType,
            'creationDate'=>$this-> creationDate,
            'status'=>$this->status,
            'totalPrice'=>$this-> totalPrice,
            'installmentPrice'=>$this-> installmentprice,
            'downPrice'=>$this-> downPrice,
            'rentPrice'=>$this-> rentPrice,
        ];
    }
}
