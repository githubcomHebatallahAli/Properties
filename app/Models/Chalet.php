<?php

namespace App\Models;

use App\Traits\DeletesMediaTrait;
use App\Traits\HandlesMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chalet extends Model
{
    use HasFactory, SoftDeletes,DeletesMediaTrait,HandlesMediaTrait;
    const MAIN_IMAGE_FOLDER = 'Chalet/mainImages';
    const IMAGE_FOLDER = 'Chalet/images';
    const VIDEO_FOLDER = 'Chalet/videos';
    const AUDIO_FOLDER = 'Chalet/audios';

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
            'roomNum',
            'pathRoomNum',
            'description',
            'area',
            'gardenArea',
            'ownerType',
            'creationDate',
            'status',
            'totalPrice',
            'installmentPrice',
            'downPrice',
            'rentPrice',
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
        return $this->morphMany(Media::class, 'mediaable');
    }


protected static function boot()
{
    parent::boot();
    static::deleting(function ($chalet) {

        $chalet->media->each(function ($media) {
            if (Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }
            $media->delete();
        });
    });

    static::forceDeleting(function ($chalet) {
        $chalet->media->each(function ($media) {
            if (Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }
            $media->forceDelete();
        });
    });
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
        return $this->belongsTo(Finish::class);
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
