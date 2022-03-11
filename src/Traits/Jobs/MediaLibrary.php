<?php
namespace BlackSpot\Starter\Traits\Jobs;

use Exception;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait MediaLibrary
{

    private function mediaLibraryRequirements()
    {
        if (!method_exists($this, 'isCreate')) {
            throw new Exception("When use ".__CLASS__." you need import the ValidateActions trait", 1);
        }

        if (!property_exists($this, 'oldFiles')) {
            throw new Exception("When use ".__CLASS__." you need create the attribute \"\$oldFiles\"", 1);
        }

        if (!method_exists($this, 'getBasePath')) {
            throw new Exception("When use ".__CLASS__." you need import the \"FilesManager\" trait", 1);
        }
    }

    /**
     * Create or update or delete the media collection of the model
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $settings
     * @return void
     */
    public function createOrUpdateOrDeleteMediaCollection($model, $settings)
    {
        $this->mediaLibraryRequirements();

        $attr = $settings['attribute'];
    
        if ($this->isCreate() && $model->{$attr} != null) {

            // If is in create mode and the model attribute != null

            $this->createOrUpdateMediaFiles($model, $settings);

        }elseif ($this->isUpdate()) {
            
            //If the model attribute is not null and the old files are news

            if ($model->{$attr} != null && ($this->oldFiles[$settings['old_files_attribute']] != $model->{$attr})) {
            
                $this->createOrUpdateMediaFiles($model, $settings);

            }else if($model->{$attr} == null){
            
                // If the is in update and the model attribute is null delete the media

                $this->deleteMedia($model, $settings);
            }else{                
                $hasMedia = $model->media()->where('collection_name', $settings['collection'])->where('name', $settings['attribute'])->exists();
                //Create in update time
                if (!$hasMedia) {
                    $this->createOrUpdateMediaFiles($model, $settings);                
                }
            }

        }
    }

    /**
     * Delete a media in collection and his folder
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $settings
     * @return void
     */
    public function deleteMedia($model, $settings)
    {   
        $mediaId = $model->media()->where('collection_name', $settings['collection'])->where('name', $settings['attribute'])->select('id')->value('id');
    
        if ($mediaId != null) {
            Media::where('id', $mediaId)->delete();
            Storage::disk(config('media-library.disk_name'))->deleteDirectory($mediaId);
        }
    }

    /** 
     * Create or update the media files collection
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $settings
     * @return void
    */
    public function createOrUpdateMediaFiles($model, $settings)
    {
        if ($this->isUpdate()) {
            $this->deleteMedia($model, $settings);
        }

        $this->filesManagerAddMedia($model, [$settings['path'], $settings['path_replacers']], $settings['attribute'], $settings['collection']);
    }

    /**
     * Copy file to spatie media-library
     * 
     */
    public function filesManagerAddMedia(object $modelInstance ,array $getFilesFolderArgs = [], string $modelAttribute, string $toCollection)
    {
        if (strpos($modelInstance->{$modelAttribute}, 'http') !== false) {
            
            if (env('APP_ENV') == 'local') {
                if (app()->runningInConsole()) {
                    dd('is an external file');
                }
            }

            return 0;
        }

        if (empty($getFilesFolderArgs)) {
            throw new Exception(__FUNCTION__.' getFilesFolderArgs is empty', 1);      
        }

        array_push($getFilesFolderArgs,$modelInstance->{$modelAttribute});

        $fileToCopy = $this->getBasePath(...$getFilesFolderArgs);

        if (file_exists($fileToCopy)) {            
            $modelInstance
                ->addMedia($fileToCopy)
                ->withCustomProperties(
                    [
                        'original_file_manager_path' => [
                            'path'            => $getFilesFolderArgs[0],
                            'path_replacers'  => $getFilesFolderArgs[1],
                            'filename'        => $getFilesFolderArgs[2],
                            'model_attribute' => $modelAttribute
                        ]
                    ]
                )
                ->preservingOriginal()
                ->usingName($modelAttribute)
                ->toMediaCollection($toCollection);
        }else{
            if (env('APP_ENV') == 'local') {
                if (app()->runningInConsole()) {
                    dd('file doesn\'t exists '. $fileToCopy);
                }
            }
        }
    }
}
