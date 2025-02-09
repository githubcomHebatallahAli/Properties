<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'path',
        'mediaable_type',
        'mediaable_id',
        'type'
        ];

    public function mediaable()
    {
        return $this->morphTo();
    }
}
