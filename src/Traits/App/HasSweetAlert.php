<?php
namespace BlackSpot\Starter\Traits\App;

use Illuminate\Support\Arr;

trait HasSweetAlert{

  public $sweetalert_browser_event = 'browser_event.sweetalert2';

  public function sweetAlert(array $detail = [])
  {
      $this->dispatchBrowserEvent($this->sweetalert_browser_event.'.open',$detail);
  }

  public function sweetAlertClose()
  {
      $this->dispatchBrowserEvent($this->sweetalert_browser_event.'.close');
  }

  public function sweetAlertNoCancelable($type, $title, $text = null, $emits = [])
  {
    return $this->sweetAlertComponent([
      'body' => [
        'type' => $type,
        'title' => $title,
        'text' => $text,
        'allowOutsideClick' => false,
        'allowEscapeKey' => false,
        'allowEnterKey' => false,
        'showCancelButton' => false,
        'showConfirmButton' => false
      ]
    ], $emits);
  }

  public function sweetAlertConfirm($icon, $title, $text, $emits = [])
  {
    return $this->sweetAlertComponent([
      'body' => [
        'type'  => $icon,
        'title' => $title,
        'text'  =>  $text,
        'allowOutsideClick'  => false,
        'allowEscapeKey'     => false,
        'allowEnterKey'      => false,
        'showCancelButton'   => true,
        'confirmButtonClass' => 'w-button w-button-green w-mx-15 mx-2 btn btn-success mr-1',
        'cancelButtonClass'  => 'w-button w-button-red w-mx-15 mx-2 btn btn-danger',
        'confirmButtonText'  => 'Si, continuar',
        'cancelButtonText'   => 'No, cancelar',
        'buttonsStyling'     => false
      ]
    ], $emits);
  }

  public function sweetAlertSuccess($title, $text, $emits = [])
  {
    return $this->sweetAlertSimple('success', $title, $text, $emits);
  }

  public function sweetAlertError($title, $text, $emits = [])
  {
    return $this->sweetAlertSimple('error', $title, $text, $emits);
  }

  public function sweetAlertInfo($title, $text, $emits = [])
  {
    return $this->sweetAlertSimple('info', $title, $text, $emits);
  }

  public function sweetAlertSimple($icon, $title, $text, $emits)
  {
    return $this->sweetAlertComponent([
      'body' => [
        'type'  => $icon,
        'title' => $title,
        'text'  => $text,
      ]
    ], $emits);
  }



  public function sweetAlertComponent($component, array $emits = [], $text = null)
  {      
    if ($component == 'confirm-delete') {
      $component = [
        'body' => [
          'type'  => 'warning',
          'title' => 'Confirmar',
          'text'  =>  $text ?? '¿Desea eliminar este recurso?',
          'allowOutsideClick'  => false,
          'allowEscapeKey'     => false,
          'allowEnterKey'      => false,
          'showCancelButton'   => true,
          'confirmButtonClass' => 'w-button w-button-green w-mx-15 mx-2 btn btn-success mr-1',
          'cancelButtonClass'  => 'w-button w-button-red w-mx-15 mx-2 btn btn-danger',
          'confirmButtonText'  => 'Si, continuar',
          'cancelButtonText'   => 'No, cancelar',
          'buttonsStyling'     => false
        ]/*,
        'immediately_after' => [
          'body' => [
            'type'  => 'info',
            'title' => 'Espere..',
            'text'  => 'Estamos esperando nueva respuesta..',
            'allowOutsideClick'  => false,
            'allowEscapeKey'     => false,
            'allowEnterKey'      => false,
            'showCancelButton'   => false,
            'showConfirmButton'  => false,
          ]
        ]*/
      ];          
    }

    $args = isset($emits['emits'])
              ? array_merge($component, $emits['emits'], Arr::except($emits,'emits'))
              : array_merge($component, $emits);

    $this->sweetAlert($args);
  }


}
