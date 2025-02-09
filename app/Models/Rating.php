<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'broker_id',
        'rating',
        'comment',
        'transactionNum',
        'completeRate',
        'creationDate'
    ];

    public function broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($rating) {
            $rating->broker->ratingsCount = $rating->broker->ratings()->count();
            $rating->broker->save();
        });

        static::deleted(function ($rating) {
            $rating->broker->ratingsCount = $rating->broker->ratings()->count();
            $rating->broker->save();
        });
    }
}
