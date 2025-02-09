<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'advNum',
    ];

    public function brokers()
{
    return $this->belongsToMany(
        Broker::class,
'package_brokers',
        'package_id',
        'broker_id'
    )->withPivot('startDate', 'endDate', 'advUseNum')
     ->withTimestamps();
}

}
