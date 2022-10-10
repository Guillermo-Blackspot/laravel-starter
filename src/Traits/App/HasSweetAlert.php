<?php

namespace BlackSpot\Starter\Traits\App;

trait HasSweetAlert
{
  public $sweetAlertEventName = 'sweetalert2';

  public function sweetAlertComponent(array $component = [])
  {
    $this->dispatchBrowserEvent("browser_event.{$this->sweetAlertEventName}.open", $component);
  }

  public function sweetAlertClose()
  {
    $this->dispatchBrowserEvent("browser_event.{$this->sweetAlertEventName}.close");
  }

  private function mixValues($original, array $mixing)
  {
    foreach ($mixing as $key => $value) {
      if (isset($original[$key])) {
        $original[$key] = $original[$key] + $value;
        continue;
      }
      $original[$key] = $value;
    }

    return $original;
  }

  public function sweetAlertNoCancelable($icon, $title, $text = null, $mixing = [])
  {
    $component = $this->mixValues([
      'body' => [
        'icon' => $icon,
        'title' => $title,
        'text' => $text,
        'allowOutsideClick' => false,
        'allowEscapeKey' => false,
        'allowEnterKey' => false,
        'showCancelButton' => false,
        'showConfirmButton' => false
      ]
    ], $mixing);

    return $this->sweetAlertComponent($component);
  }

  public function sweetAlertConfirm($title, $text, $mixing = [])
  {
    $component = $this->mixValues([
      'body' => [
        'icon' => 'warning',
        'title' => $title,
        'text' =>  $text,
        'allowOutsideClick' => false,
        'allowEscapeKey' => false,
        'allowEnterKey' => false,
        'showCancelButton' => true,
        'customClass' => [
          'confirmButton' => 'w-button w-button-green w-mx-15 mx-2 btn btn-success rounded mr-1',
          'cancelButton' => 'w-button w-button-red w-mx-15 mx-2 btn btn-danger rounded '
        ],
        'confirmButtonText' => 'Si, continuar',
        'cancelButtonText' => 'No, cancelar',
        'buttonsStyling' => false
      ]
    ], $mixing);
    return $this->sweetAlertComponent($component);
  }

  public function sweetAlertSuccess($title, $text, $mixing = [])
  {
    return $this->sweetAlertSimple('success', $title, $text, $mixing);
  }

  public function sweetAlertQuestion($title, $text, $mixing = [])
  {
    return $this->sweetAlertSimple('question', $title, $text, $mixing);
  }

  public function sweetAlertError($title, $text, $mixing = [])
  {
    return $this->sweetAlertSimple('error', $title, $text, $mixing);
  }

  public function sweetAlertInfo($title, $text, $mixing = [])
  {
    return $this->sweetAlertSimple('info', $title, $text, $mixing);
  }

  public function sweetAlertSimple($icon, $title, $text, $mixing)
  {
    $component = $this->mixValues([
      'body' => [
        'icon'  => $icon,
        'title' => $title,
        'text'  => $text,
      ]
    ], $mixing);

    return $this->sweetAlertComponent($component);
  }
}
