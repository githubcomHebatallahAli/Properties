<?php

namespace App\Models;

use App\Traits\DeletesMediaTrait;
use App\Traits\HandlesMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory, SoftDeletes, DeletesMediaTrait,HandlesMediaTrait;
    // const MAIN_IMAGE_FOLDER = 'Property/mainImages';
    // const IMAGE_FOLDER = 'Property/images';
    // const VIDEO_FOLDER = 'Property/videos';
    // const AUDIO_FOLDER = 'Property/audios';
    // public function handleFileCreateMedia($request)
    // {
    //     $this->handleFiles($request, $this, [
    //         'mainImage' => self::MAIN_IMAGE_FOLDER,
    //         'images' => self::IMAGE_FOLDER,
    //         'video' => self::VIDEO_FOLDER,
    //         'audio' => self::AUDIO_FOLDER,
    //     ]);
    // }

    // public function handleFileUpdateMedia($request)
    // {
    //     $this->handleFiles($request, $this, [
    //         'mainImage' => self::MAIN_IMAGE_FOLDER,
    //         'images' => self::IMAGE_FOLDER,
    //         'video' => self::VIDEO_FOLDER,
    //         'audio' => self::AUDIO_FOLDER,
    //     ], true);
    // }
    protected $fillable = [
        'user_id',
        'admin_id',
        'installment_id',
        'finish_id',
        'transaction_id',
        'water_id',
        'electricty_id',
        'governorate',
        'city',
        'district',
        'street',
        'locationGPS',
        'facade',
        'propertyNum',
        'description',
        'area',
        'ownerType',
        'creationDate',
        'status',
        'sale',
        'totalPrice',
        'installmentPrice',
        'downPrice',
        'rentPrice',
    ];


    protected $casts = [
        'images' => 'array',
    ];

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


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

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    public function finish()
    {
        return $this->belongsTo(Finish::class);
    }

    // public function broker()
    // {
    //     return $this->belongsTo(Broker::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
