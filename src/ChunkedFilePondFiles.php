<?php

namespace BlackSpot\Starter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChunkedFilePondFiles
{
    public function getTempPath($serverId)
    {
        $filePond = app(\Sopamo\LaravelFilepond\Filepond::class);
        $disk     = config('filepond.temporary_files_disk');
        $filePath = $filePond->getPathFromServerId($serverId);
        
        if (! Storage::disk($disk)->exists($filePath)) {
            return ;
        }

        return Storage::disk($disk)->path($filePath);
    }

    public function moveToMediaCollection($model, $serverId, $fileName, $toCollection = 'default')
    {
        $tempFullPath = $this->getTempPath($serverId);

        if (! $tempFullPath) return;

        $model->addMedia($tempFullPath)
            ->usingFileName($fileName)
            ->toMediaCollection($toCollection);

        return $fileName;
    }

    public function moveToFinalDirectory($serverId, $finalDirectory)
    {
        $tempFullPath = $this->getTempPath($serverId);

        if (! $tempFullPath) return;

        // Create directory if not exists
        if (! File::isDirectory(dirname($finalDirectory))) {
            File::makeDirectory(dirname($finalDirectory), 0777, true, true);
        }

        File::move($tempFullPath, $finalDirectory);

        return $finalDirectory;        
    }
}
