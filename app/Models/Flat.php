<?php

namespace App\Models;

use App\Traits\DeletesMediaTrait;
use App\Traits\HandlesMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flat extends Model
{
    use HasFactory, SoftDeletes, DeletesMediaTrait,HandlesMediaTrait;
    const MAIN_IMAGE_FOLDER = 'Flat/mainImages';
    const IMAGE_FOLDER = 'Flat/images';
    const VIDEO_FOLDER = 'Flat/videos';
    const AUDIO_FOLDER = 'Flat/audios';
    public function handleFileCreateMedia($request)
    {
        $this->handleFiles($request, $this, [
            'mainImage' => self::MAIN_IMAGE_FOLDER,
            'image' => self::IMAGE_FOLDER,
            'video' => self::VIDEO_FOLDER,
            'audio' => self::AUDIO_FOLDER,
        ]);
    }

    public function handleFileUpdateMedia($request)
    {
        $this->handleFiles($request, $this, [
            'mainImage' => self::MAIN_IMAGE_FOLDER,
            'image' => self::IMAGE_FOLDER,
            'video' => self::VIDEO_FOLDER,
            'audio' => self::AUDIO_FOLDER,
        ], true);
    }
    protected $fillable = [
        'broker_id',
        'user_id',
        'admin_id',
        'installment_id',
        'finishe_id',
        'transaction_id',
        'property_id',
        'water_id',
        'electricty_id',
        'sale',
        'governorate',
        'city',
        'district',
        'street',
        'locationGPS',
        'facade',
        'propertyNum',
        'floorNum',
        'flatNum',
        'roomNum',
        'pathRoomNum',
        'description',
        'area',
        'ownerType',
        'creationDate',
        'status',
        'totalPrice',
        'installmentPrice',
        'downPrice',
        'rentPrice',
        'gardenArea',
        'roofArea',
        'mainImage',
        'image',
        'video',
        'audio',
    ];


    protected $casts = [
        'image' => 'array',
    ];

    public function media()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function electricty()
    {
        return $this->belongsTo(Electricity::class);
    }

    public function water()
    {
        return $this->belongsTo(Water::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // public function sale()
    // {
    //     return $this->belongsTo(Sale::class);
    // }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    public function finish()
    {
        return $this->belongsTo(Finishe::class);
    }

    public function broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
