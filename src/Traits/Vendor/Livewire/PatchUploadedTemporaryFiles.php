<?php

namespace BlackSpot\Starter\Traits\Vendor\Livewire;

use Illuminate\Support\Facades\Storage;

trait PatchUploadedTemporaryFiles
{
    public function tempUrlFile($file)
    {
        return asset("/livewire-files/{$file->getFilename()}");
    }
}
