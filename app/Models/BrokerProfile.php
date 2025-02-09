<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrokerProfile extends Model
{
    const PHOTO_FOLDER = 'Broker';
    protected $fillable = [
        'photo',
        'birthDate',
        'email',
        'email_verified_at',
        'commission',
        'brief',
        'targetPlace',
        'realEstateType',
        'photo',
        'birthDate',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}
