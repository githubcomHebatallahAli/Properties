<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


trait HandlesMediaTrait
{
    public function handleFiles(Request $request, $model, array $fileFields, $isUpdate = false)
    {
        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                if ($isUpdate && $model->$field) {
                    $this->deleteOldFiles($model->$field);
                }

                if (is_array($request->file($field))) {
                    $paths = [];
                    foreach ($request->file($field) as $file) {
                        $paths[] = $file->store($folder, 'public');
                    }
                    $model->$field = $paths;
                } else {
                    $model->$field = $request->file($field)->store($folder, 'public');
                }
            }
        }
    }


    protected function deleteOldFiles($files)
    {
        if (is_array($files)) {
            foreach ($files as $file) {
                Storage::disk('public')->delete($file);
            }
        } else {
            Storage::disk('public')->delete($files);
        }
    }
}
