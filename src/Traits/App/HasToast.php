<?php

namespace BlackSpot\Starter\Traits\App;

use Illuminate\Support\Arr;

trait HasToast
{
  public $toastEventName = 'toastr';

  private function dispatchToast($options)
  {
    $this->dispatchBrowserEvent("browser_event.{$this->toastEventName}",$options);
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
  public function simpleToast($success, $successMessage = '¡Exito!', $errorMessage = 'Error')
  {
    if ($success) return $this->toastSuccess($successMessage);

    return $this->toastError($errorMessage);
  }
}
