<?php 

namespace BlackSpot\Starter\Traits\Vendor\Livewire;


trait HasLazyRendering
{
 
    public $isReady = false;

    /**
     * Validate if component is ready
     */
    public function isReady()
    {
        return $this->isReady;
    }

    /**
     * Change the ready state
     *
     * @param bool $isReady 
     * @return void
     */
    public function setReadyState($isReady)
    {
        $this->isReady = $isReady;
    }


    


}
