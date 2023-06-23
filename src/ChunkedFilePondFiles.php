<?php

namespace BlackSpot\Starter;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChunkedFilePondFiles
{
    /**
     * Get the temporary path of the file with related serverId
     *
     * @param string $serverId
     * @return string
     */
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

    /**
     * Make a random name with the incoming extension
     * 
     * @param string $fileExtension
     * @param int $length
     * @return string
     */
    public static function makeRandomName($fileExtension, $length = 40)
    {
        return Str::slug(Str::random($length)) . '.' . $fileExtension;
    }

    /**
     * Move temporary file to spatie media collection
     *
     * @param \Spatie\MediaLibrary\HasMedia $model
     * @param string $serverId
     * @param string $fileName
     * @param string $collectionName
     * @return string
     */
    public function moveToMediaCollection($model, $serverId, $fileName, $collectionName = 'default')
    {
        $tempFullPath = $this->getTempPath($serverId);

        if (! $tempFullPath) return;

        $model->addMedia($tempFullPath)
            ->usingFileName($fileName)
            ->toMediaCollection($collectionName);

        return $fileName;
    }

    /**
     * Move temporary file to directory
     *
     * @param string $serverId
     * @param string $finalDirectory
     * @return string
     */
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
