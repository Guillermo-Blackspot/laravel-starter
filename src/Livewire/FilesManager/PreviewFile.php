<?php
namespace BlackSpot\Starter\Livewire\FilesManager;

use BlackSpot\Starter\Traits\App\HasModal;
use BlackSpot\Starter\Traits\App\HasSweetAlert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;

class PreviewFile extends Component
{
    use HasSweetAlert, HasModal;

    public $listenerId = 'filesmanager';
    public $viewLocation, $location = 'bootstrap';


    public $fullUrl;

    public $fileAsset,
           $fileType,
           $fakePath,           
           $isInsideOfStorage,
           $isInsideOfPublic,
           $isExternal,
           $diskInUse, 
           $fileUrlUri,
           $invalidFile,
           $mode,
           $fileContent,
           $fileTitle;



    public function mount()
    {
        $this->fullUrl = url('/');
    }

    public function render()
    {        
        if ($this->viewLocation == null) {
            $this->viewLocation = str_replace('/','.',config('filesmanager.file_viewing_layouts.bootstrap'));
        }        
        
        return view('livewire.'.$this->viewLocation);
    }

    protected function getListeners()
    {
        return [
          "{$this->listenerId}.setFile" => 'setFile',
          "{$this->listenerId}.getFileContentAndDisplayIt" => 'setFileFromGetContents',
        ];
    }       

    /**
     * Extract the fileTitle and the file asset link
     * 
     * @param string|array $fileAsset
     * @param string|null $default
     * @return void
     */
    public function parseAsset($fileAsset, $default)
    {
        if (is_array($fileAsset)) {
            $this->fileTitle = $fileAsset[0];
            $fileAsset = $fileAsset[1];
        }

        $this->fileAsset = blank($fileAsset) ? $default : $fileAsset;;
    }

    /**
     * Validate if is inside of public_html folder
     */
    private function insideOfPublic()
    {
        if ($this->isInsideOfStorage) {
            return $this->isInsideOfPublic = false;
        }
        
        $inside = Str::contains($this->fileAsset, $this->fullUrl);

        if ($inside) {
            $this->fileUrlUri = str_replace($this->fullUrl, ' ', $this->fileAsset);
            $this->fakePath   = str_replace('/', ' > ', $this->fileUrlUri);
            if (file_exists(public_path(ltrim(trim($this->fileUrlUri),'/')))) {
                $this->fileType   = File::mimeType(public_path(ltrim(trim($this->fileUrlUri),'/')));                
            }
        }

        return $this->isInsideOfPublic = $inside;
    }

    /**
     * Validate if is inside of storage folder
     */
    private function insideOfStorage()
    {
        if ($this->isInsideOfPublic) {
            return $this->isInsideOfStorage = false;
        }

        /**
         * Foreach register validators for storage folder validate if its inside
         */

        $validators = collect(config('filesmanager.file_viewing_disks'));

        return $this->isInsideOfStorage = $validators->some(function ($disk, $key) {
            $urlReplacer = Storage::disk($disk)->url('/');
            $filePath    = str_replace($urlReplacer, '', $this->fileAsset);
            $inside      = Storage::disk($disk)->exists($filePath);
            if ($inside) {
                $this->diskInUse  = $disk;
                $this->fileUrlUri = $filePath;
                $this->fakePath   = str_replace('/', ' > ', $this->fileUrlUri);
                $this->fileType   = File::mimeType(Storage::disk($disk)->path($filePath));
            }
            return $inside;
        });
    }


    
    public function setFile($location, $fileAsset, $default = null)
    {
        $this->sweetAlertClose();    

        $viewLocation       = str_replace('/','.',config('filesmanager.file_viewing_layouts.'.$location));    
        $this->viewLocation = $viewLocation;
        $this->location     = $location;
        $this->mode         = 'SIMPLE-FILE';    
        $this->parseAsset($fileAsset, $default);
        $this->insideOfStorage();
        $this->insideOfPublic();
        $this->isExternal = $this->isInsideOfStorage == false && $this->isInsideOfPublic == false;

        if ($this->isExternal) {
            if (Str::contains($this->fileAsset, ['.jpg','.jpeg','.png','.gif'])){
                $this->fileType = 'image';
            }elseif (Str::contains($this->fileAsset, ['.mp4'])){
                $this->fileType = 'video';
            }elseif (Str::contains($fileAsset,['youtube','you.be'])) {
                $this->fileType = 'youtube';
            }
        }
        
        if (is_null($this->fileType)) {
            $this->invalidFile = true;
        }

        $this->openModal($this->modalId, $this->location);        
    }


    public function setFileFromGetContents($url, $default = null)
    {
        $this->sweetAlertClose();
        $this->parseAsset($url, $default);
        
        //$uriFileAsset   = $this->removeBaseUrlFromAsset($this->fileAsset);
        $this->fakePath = str_replace('/',' > ',$uriFileAsset);
        $this->mode     = 'GET-CONTENTS';
        $this->isExternal = $this->isInsideOfStorage == false && $this->isInsideOfPublic == false;
    }

    public function resetInputFields()
    {
        $this->reset([
          'fileAsset',
          'fileType',
          'fakePath',
          'isInsideOfStorage',
        ]);
    }
}
