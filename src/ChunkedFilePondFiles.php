<?php

namespace BlackSpot\Starter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChunkedFilePondFiles
{
    public function moveToMediaCollection($model, $serverId, $fileName, $toCollection = 'default')
    {
        $filePond = app(\Sopamo\LaravelFilepond\Filepond::class);
        $disk     = config('filepond.temporary_files_disk');
        $filePath = $filePond->getPathFromServerId($serverId);

        if (! Storage::disk($disk)->exists($filePath)) {
            return null;
        }

        $model->addMedia(Storage::disk($disk)->path($filePath))
            ->usingFileName($fileName)
            ->toMediaCollection($toCollection);

        return $fileName;
    }

    public static function moveToFinalDirectory($serverId, $finalDirectory)
    {
        // Get the temporary path using the serverId returned by the upload function in `FilepondController.php`
        $filePond = app(\Sopamo\LaravelFilepond\Filepond::class);
        $disk     = config('filepond.temporary_files_disk');
        $filePath = $filePond->getPathFromServerId($serverId);

        // Update null
        if (! Storage::disk($disk)->exists($filePath)) {            
            return ;
        }
        
        $tempFullPath = Storage::disk($disk)->path($filePath);

        // Create directory if not exists
        if (! File::isDirectory(dirname($finalDirectory))) {
            File::makeDirectory(dirname($finalDirectory), 0777, true, true);
        }

        File::move($tempFullPath, $finalDirectory);

        return $finalDirectory;        
    }
}
