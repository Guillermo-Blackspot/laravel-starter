<?php

namespace BlackSpot\Starter\Traits\App;

use Illuminate\Support\Arr;

trait HasToast
{
  public $toastr_browser_event = 'browser_event.toastr';

  private function dispatchToast($options)
  {
    $this->dispatchBrowserEvent($this->toastr_browser_event,$options);
  }

  public function toast(...$args)
  {
      if (isset($args[0]) && is_array($args[0]) && Arr::isAssoc($args[0])) {
        return $this->dispatchToast([
          'component' => $args[0]
        ]);
      }else{
        $options = [];
        if (isset($args[0])) {
          $options[] = $args[0];
        }
        if (isset($args[1])) {
          $options[] = $args[1];
        }
        if (isset($args[2])) {
          $options[] = $args[2];
        }
        if (isset($args[3])) {
          $options[] = $args[3];
        }          
        $this->dispatchToast([
          'component' => $options
        ]);
      }
  }

  public function toastSuccess(...$args)
  {
      $this->toast('success',...$args);
  }
  public function toastError(...$args)
  {
    $this->toast('error',...$args);
  }
  public function toastWarning(...$args)
  {
    $this->toast('warning',...$args);
  }
  public function toastInfo(...$args)
  {
    $this->toast('info',...$args);
  }

  /**
   * Show an simple toast message from an bool parameter
   * 
   * @param bool $success
   * @param string|null $successMessage
   * @param string|null $errorMessage
   */
  public function simpleToast($success, $successMessage = null, $errorMessage = null)
  {
    if ($successMessage == null) {
      $successMessage = '¡Exito!';
    }

    if ($errorMessage == null) {
      $errorMessage = 'Error';
    }

    if ($success) {
      $this->toastSuccess($successMessage);
    }else{
      $this->toastError($errorMessage);
    }

  }
}
