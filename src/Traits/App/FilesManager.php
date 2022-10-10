<?php
namespace BlackSpot\Starter\Traits\App;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Livewire\TemporaryUploadedFile;

trait FilesManager
{

  /**
   * Delete a directory from storage folder
   *
   * @param string $path
   * @param array $pathReplacers
   * @param boolean $enableThrows
   **/
  public function deleteDirectory(string $path, array $pathReplacers = [], $enableThrows = false)
  {
    try {      
      return $this->getDiskInstance()->deleteDirectory($this->getFilesFolder($path, $pathReplacers, true));
    } catch (\Exception $err) {
      if ($enableThrows) {
        throw $err;
      }
      return false;
    }    
  }


  /**
   * Delete a file from an directory
   * 
   * @param string $configPath
   * @param array $pathReplacers
   * @param string $filename
   * @return bool
   */
  public function deleteFile(string $configPath, array $pathReplacers = [], string $filename)
  {
    return $this->getDiskInstance()->delete(
      $this->getFilesFolder($configPath,$pathReplacers).'/'.$filename
    );
  }

  /**
   * Delete files if is inside of the directory
   * 
   * @param string $path
   * @param array $pathReplacers
   * @param array $fileNames
   * @return bool
   */
  public function deleteFilesWithDirectory(string $path, array $pathReplacers = [], array $fileNames)
  {
    $filesFolder = $this->getFilesFolder($path, $pathReplacers);
    $fileNames   = array_filter($fileNames, function ($value) {
      return $value !== null && $value !== '' && strpos($value,'.') !== false;
    });

    if (empty($fileNames)) {
      return true;
    }

    foreach ($fileNames as $index => $file) {
      $fileNames[$index] = $filesFolder.'/'.$file;
    }

    return $this->getDiskInstance()->delete($fileNames) ?? true;
  }

  /**
   * Move a request file
   * 
   * @param \Illuminate\Support\Facades\Request $request
   * @param string $fileName
   * @param string $path
   * @param array $pathReplacers
   * @param string $currentFilename
   * @return string
   */
  public function moveRequestFile(Request $request, string $filename, string $path, array $pathReplacers = [], string $currentFilename = '')
  {
    if (!$request->hasFile($filename)) {
      return null;
    }

    $directory = $this->getFilesFolder($path, $pathReplacers);

    // If its an edition and the old value is not null, delete it 

    if (!empty($currentFilename)) {            
      Storage::delete($directory.'/'.basename($currentFilename));
    }
    
    return basename($request->{$filename}->store($directory));
  }

  /**
  * Move the file or replace it
  *
  * @return string|null
  */
  public function moveLivewireFile(string $attributeName, string $path, array $pathReplacers = [], string $modelOrFileToReplace = '')
  {
    // Accessing to the file object

    if (isset($this->attachedFiles) && $this->attachedFiles != []) {
      $livewireAttributeValue = $this->attachedFiles[$attributeName];
    }else{
      $livewireAttributeValue = $this->{$attributeName} ?? null;
    }

    // is null return null

    if (is_null($livewireAttributeValue)) {
      return null;
    }

    $directory = $this->getFilesFolder($path, $pathReplacers, true);

    // It's a file try to store
    
    if ($livewireAttributeValue instanceof TemporaryUploadedFile) {
      
      // if its an edition and the old value is not null, delete it 

      if (in_array($this->formType, ['edit','update']) && !empty($modelOrFileToReplace)) {          
        if (!Str::contains($modelOrFileToReplace, '.')) {
          
          // Its a model name            
          
          if (!Str::contains($modelOrFileToReplace, ':') && !isset(explode(':',$modelOrFileToReplace)[1])) {
            throw new Exception("The model must have the name of attribute to get the actual file [model:attribute]", 1);            
          }

          $exp = explode(':', $modelOrFileToReplace);
          $modelOrFileToReplace = $this->{$exp[0]}->{$exp[1]};
        }

        if (Str::contains($modelOrFileToReplace,'http') == false) {
          $this->getDiskInstance()->delete($directory.'/'.basename($modelOrFileToReplace));          
        }

      }

      // Move the file and return the basename

      return basename($livewireAttributeValue->store($directory, $this->getDiskName()));
    }

    // If its not an object and its a string and its in edit mode just do nothing and returns the same value

    if (in_array($this->formType,['edit','update']) && $livewireAttributeValue != null) {
      if (strpos($livewireAttributeValue,'http') !== false) {
        return $livewireAttributeValue;
      }
      return basename($livewireAttributeValue);
    }
  }

  /**
   * Validate if is a directory
   * 
   * @param string $path
   * @return bool
   */
  public function isDirectory($path)
  {
      return !Str::contains(basename($path),'.');
  }

  /**
   * Validate if not is a directory
   * 
   * @param string $path
   * @return bool
   */
  public function isNotADirectory($path)
  {
    return $this->isDirectory($path) == false;
  }

  /**
   * Get the file as asset link
   * 
   * @param string $path
   * @param array $pathReplacers = []
   * @param bool $ifIsNotADirectoryNotForceIt = true
   * 
   * @return string 
   */
  public function getFileAsset(string $path, array $pathReplacers = [], $forceToBeADirectory = false)
  {
    return $this->getDiskInstance()->url($this->getFilesFolder($path, $pathReplacers, $forceToBeADirectory));
  }

  /**
   * Replace all parameters in a path
   * 
   * @param string $path
   * @param array $pathReplacers
   * @return bool
   */
  private function replaceParametersInPath(string $path, array $pathReplacers = [])
  {
    //$path = basename(config('filesystems.disks.filesmanager.root')). '/' .config('filesmanager.files.'.$path);
    $path = config('filesmanager.files_and_folders.'.$path);
  
    if (!empty($pathReplacers)) {
      foreach ($pathReplacers as $replacer => $value) {
        $path = str_replace($replacer,$value,$path);
      }
    }

    throw_if(is_array($path),__FUNCTION__.' : The resulting path is an array');

    return str_replace('//','/', str_replace('\\\\','\\',trim($path,'/')));
  }

  /**
   * Get the base base of the an file
   * 
   * @param string $path
   * @param array $pathReplacers = []
   * @return string
   */
  public function getBasePath(string $path, array $pathReplacers = [], string $join = '', $forceToBeADirectory = true)
  {
    if ($join != '') {
      $join = '/' . ltrim($join,'/');
    }

    return $this->getDiskInstance()->path($this->getFilesFolder($path,$pathReplacers, $forceToBeADirectory).$join);
  }
  

  /**
   * Get the files folder
   * 
   * @param string $path
   * @param array $pathReplacers
   * @throws \Exception
   * @return string
   */
  public function getFilesFolder(string $path, array $pathReplacers = [], $forceToBeADirectory = true)
  {
    $path = $this->replaceParametersInPath($path, $pathReplacers);

    if($this->isNotADirectory($path)) {
      if ($forceToBeADirectory == true) {
        $path = dirname($path);        
      }
    }

    throw_if(empty($path) || is_null($path), '['.__FUNCTION__.'] Directory Or File Not Found!');

    return trim($path);
  }

  /**
   * Preview Files
   * 
   * @param string $location
   * @param string|array $url
   * @param string|null $defaultUrl
   * @return void
   */
  public function setPreviewFile(string $location, $url, $defaultUrl = null)
  {    
    $this->emitTo('addons.files-manager.preview-file', 'filesmanager.setFile', $location, $url, $defaultUrl);
  }


  /**
   * Get the content of an url and display in a iframe
   * 
   * @return void
   */
  public function getFileContentAndDisplayIt(string $base, $url, $defaultUrl = null, string $listenerId = 'filesmanager')
  {
    $this->emitTo("{$base}.addons.files-manager.preview-files", $listenerId.'.getFileContentAndDisplayIt',$url, $defaultUrl);
  }

  public function getDiskInstance()
  {    
    return Storage::disk(config('filesmanager.disk_name'));
  }

  public function getDiskName()
  {
    return config('filesmanager.disk_name');
  }
}
