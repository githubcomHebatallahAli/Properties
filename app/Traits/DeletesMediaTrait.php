<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait DeletesMediaTrait
{

    protected static function bootDeletesMediaTrait()
    {
        static::deleting(function ($model) {

            if (method_exists($model, 'media')) {

                $model->media->each(function ($media) {

                    if (Storage::disk('public')->exists($media->path)) {
                        Storage::disk('public')->delete($media->path);
                    }

                    $media->delete();
                });
            }
        });

        static::forceDeleting(function ($model) {

            if (method_exists($model, 'media')) {

                $model->media->each(function ($media) {

                    if (Storage::disk('public')->exists($media->path)) {
                        Storage::disk('public')->delete($media->path);
                    }
                    
                    $media->forceDelete();
                });
            }
        });
    }
}
