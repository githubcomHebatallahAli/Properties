<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'status',
    ];

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    public function chalets()
    {
        return $this->hasMany(Chalet::class);
    }

    public function villas()
    {
        return $this->hasMany(Villa::class);
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function lands()
    {
        return $this->hasMany(Land::class);
    }

    public function offices()
    {
        return $this->hasMany(Office::class);
    }
}
