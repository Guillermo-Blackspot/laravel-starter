<?php
namespace BlackSpot\Starter\Traits\App;

trait HasModal
{
    public $modalId;
 
    public function openModal($modalId = null, $lib = 'bootstrap')
    {
        $this->dispatchBrowserEvent("browser_event.{$lib}.modal-open", [
           'modalId' => ($modalId ?? $this->modalId)
        ]);
    }    

    public function closeModal($modalId = null, $lib = 'bootstrap')
    {
        $this->dispatchBrowserEvent("browser_event.{$lib}.modal-close", [
           'modalId' => ($modalId ?? $this->modalId)
        ]);
    }

}
