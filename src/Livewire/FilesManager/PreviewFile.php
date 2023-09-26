<?php
namespace BlackSpot\Starter\Livewire\FilesManager;

use BlackSpot\Starter\Traits\App\HasModal;
use BlackSpot\Starter\Traits\App\HasSweetAlert;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class PreviewFile extends Component
{
    use HasSweetAlert, HasModal;

    public $theme = 'bootstrap';
    public $mode  = 'simple-file';
    public $title;
    public $description;
    public $fileType;
    public $fileUrl;
    public $componentView;

    public const SIMPLE_FILE_TYPE  = 'simple-file';
    public const GET_CONTENTS_TYPE = 'get-contents';

    protected $listeners = [
        'filesmanager.setFile' => 'setFile',
        'filesmanager.getFileContentAndDisplayIt' => 'setFileFromGetContents',
    ];

    public function mount()
    {
        $this->componentView = str_replace('/','.',config('filesmanager.file_viewing_layouts.' . $this->theme));
    }

    public function render()
    {        
        return view('livewire.' . $this->componentView);
    }

    /**
     * Extract the file attributes from 
     * file
     * 
     * @param string|array $file
     * @param string|null $default
     * @return void
     */
    private function setFileAttributes($file, $default = null)
    {
        if (Arr::isAssoc($file)) {
            $this->title          = $file['title'] ?? null;
            $this->description    = $file['description'] ?? null;
            $this->fileUrl        = $file['file'];
            
            if (! $this->fileUrl) {
                $this->fileUrl = $file['defaultFile'] ?? $default;
            }
        }else if (is_array($file)) {
            $this->title          = $file[0];
            $this->fileUrl        = $file[1];
            $this->description    = $file[2] ?? null;

            if (! $this->fileUrl) {
                $this->fileUrl = $default;
            }
        }else {
            $this->file = ! $file ? $default : $file;
        }
    }

    private function setComponentTheme($theme)
    {
        $this->theme         = $theme;
        $this->componentView = str_replace('/','.',config('filesmanager.file_viewing_layouts.'.$theme));
    }
    
    public function setFile($theme, $file, $default = null)
    {
        $this->sweetAlertClose();
        $this->setComponentTheme($theme);
        $this->setFileAttributes($file, $default);

        if ($this->fileUrl) {
            $extension = '.' . trim(substr(strrchr($this->fileUrl, '.'), 1));
    
            if (in_array($extension, ['.webp','.jpg','.jpeg','.png','.gif'])) {
                $this->fileType = 'image';
            }else if (in_array($extension, ['.mp4', '.mov'])) {
                $this->fileType = 'video';
            }else if (in_array($extension, ['youtube','you.be'])) {
                $this->fileType = 'youtube';
            }else {
                $this->fileType = 'try_to_image';
            }
        }else {
            $this->fileType = false;;
        }

        $this->mode = self::SIMPLE_FILE_TYPE;

        $this->openModal($this->modalId, 'bootstrap');
    }


    public function setFileFromGetContents($theme, $file, $default = null)
    {
        $this->sweetAlertClose();
        $this->setComponentTheme($theme);
        $this->setFileAttributes($file, $default);

        $this->mode = self::GET_CONTENTS_TYPE;
        $this->openModal($this->modalId, 'bootstrap');
    }

    public function resetInputFields()
    {
        $this->reset([
            'title',
            'description',
            'fileType',
            'fileUrl',
        ]);
    }
}
