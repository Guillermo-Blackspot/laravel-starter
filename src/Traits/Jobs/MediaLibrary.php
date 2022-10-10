<?php
namespace BlackSpot\Starter\Traits\Jobs;

use Exception;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait MediaLibrary
{
    use ValidateActions;
    
    /**
     * Create or update or delete the media collection of the model
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $settings
     * @return void
     */
    public function createOrUpdateOrDeleteMediaCollection($model, $settings)
    {
        $attributeName  = $settings['attribute'];
        $attributeValue = $model->{$attributeName};

        // ON CREATE ACTIONS

        // On create if model attribute value is not null, create his media
        // Internally it'll make his conversions
        if ($this->isCreate()) {
            if ($attributeValue != null) return $this->createOrUpdateMediaFile($model, $settings); 
            return ;
        }

        // -----------------------------------------------------------------------------------------------
        // ON UPDATE ACTIONS

        // On update if model attribute value is null delete the media
        // Internally it'll delete his folder
        if ($attributeValue == null) return $this->deleteMedia($model, $settings);


        // If the model attribute value is not null and there are news files
        // Update them
        if ($this->oldFiles[$settings['old_files_attribute']] != $attributeValue) {
            return $this->createOrUpdateMediaFile($model, $settings);
        }
    
        // At this point we need check if the model has a existing media with the collection name
        // if not exists, make it
        $hasMedia = $model->media()
                        ->where('collection_name', $settings['collection'])
                        ->where('name', $settings['attribute'])
                        ->exists();

        if (!$hasMedia) return $this->createOrUpdateMediaFile($model, $settings);
        
        // Unknown changes
        return;
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
    
        if ($mediaId == null) return;

        Media::where('id', $mediaId)->delete();
        Storage::disk(config('media-library.disk_name'))->deleteDirectory($mediaId);
    }

    /** 
     * Create or update the media files collection
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $settings
     * @return void
    */
    public function createOrUpdateMediaFile($model, $settings)
    {
        if ($this->isUpdate()) $this->deleteMedia($model, $settings);

        $this->filesManagerAddMedia($model, [$settings['path'], $settings['path_replacers']], $settings['attribute'], $settings['collection']);
    }

    /**
     * Copy file to spatie media-library
     * 
     */
    public function filesManagerAddMedia(object $model ,array $filesFolderArguments = [], string $modelAttribute, string $toCollection)
    {

        // Is an external file
        if (strpos($model->{$modelAttribute}, 'http') !== false) {            
            if (env('APP_ENV') == 'local' && app()->runningInConsole()) dd('is an external file');            
            return 0;
        }

        throw_if(empty($filesFolderArguments), __FUNCTION__.' filesFolderArguments is empty');


        array_push($filesFolderArguments,$model->{$modelAttribute});

        $fileToCopy = $this->getBasePath(...$filesFolderArguments);

        if (file_exists($fileToCopy)) {            
            $model
                ->addMedia($fileToCopy)
                ->withCustomProperties(
                    [
                        'original_file_manager_path' => [
                            'path'            => $filesFolderArguments[0],
                            'path_replacers'  => $filesFolderArguments[1],
                            'filename'        => $filesFolderArguments[2],
                            'model_attribute' => $modelAttribute
                        ]
                    ]
                )
                ->preservingOriginal()
                ->usingName($modelAttribute)
                ->toMediaCollection($toCollection);

            return;
        }
        

        if (env('APP_ENV') == 'local' && app()->runningInConsole()) dd('file doesn\'t exists '. $fileToCopy);
    }
}
