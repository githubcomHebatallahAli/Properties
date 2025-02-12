<?php

namespace App\Models;

use App\Traits\DeletesMediaTrait;
use App\Traits\HandlesMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory, DeletesMediaTrait,HandlesMediaTrait;
    const MAIN_IMAGE_FOLDER = 'Property/mainImages';
    const IMAGE_FOLDER = 'Property/images';
    const VIDEO_FOLDER = 'Property/videos';
    const AUDIO_FOLDER = 'Property/audios';
    public function handleFileCreateMedia($request)
    {
        $this->handleFiles($request, $this, [
            'mainImage' => self::MAIN_IMAGE_FOLDER,
            'images' => self::IMAGE_FOLDER,
            'video' => self::VIDEO_FOLDER,
            'audio' => self::AUDIO_FOLDER,
        ]);
    }

    public function handleFileUpdateMedia($request)
    {
        $this->handleFiles($request, $this, [
            'mainImage' => self::MAIN_IMAGE_FOLDER,
            'images' => self::IMAGE_FOLDER,
            'video' => self::VIDEO_FOLDER,
            'audio' => self::AUDIO_FOLDER,
        ], true);


    }

    protected $fillable = [
        'property_id',
        'mainImage',
        'images',
        'video',
        'audio'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
