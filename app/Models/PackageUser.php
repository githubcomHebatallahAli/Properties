<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageBroker extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'broker_id',
        'package_id',
        'startDate',
        'endDate',
        'advUseNum'
    ];
}
