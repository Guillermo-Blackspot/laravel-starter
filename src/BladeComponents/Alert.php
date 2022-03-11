<?php

namespace BlackSpot\Starter\BladeComponents;

use BlackSpot\Starter\BladeComponents\BaseComponent;

class Alert extends BaseComponent
{

    public $type, $dismiss, $session, $sessionName, $show, $title, $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($show = true, $type, $dismiss = false, $session = false, $sessionName = null, $title = null, $text = null, $theme = 'bootstrap4')
    {
        parent::__construct(compact('type','session','sessionName','text','show','dismiss','title','theme'));

        $this->mergeCastAttributeRules([
            'session'     => 'boolean',
            'dismiss'     => 'boolean',
            'session'     => 'fn:castSession',
            'sessionName' => 'fn:castSessionName',
            'text'        => 'fn:castAlertText',
            'show'        => 'fn:castShowAlert'
        ]);
        
        /**
         * Filling and casting all the constructor attributes
         */        
        $this->fillAttributes();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return parent::render();
    }

    /**
     * Verifying if the session attribute contains the session flash name
     * 
     * @param mixed $originalValue
     * @return boolean
     */
    public function castSession($originalValue)
    {
        if (strpos($originalValue,':') !==  false) {
            return $this->filterBoolean(explode(':',$originalValue)[0]);
        }
        return $this->filterBoolean($originalValue);
    }
    
    /**
     * If alert from of session flash get the session name from the session:name attribute
     * or take it from the session-name attribute 
     *
     * @param mixed $originalValue
     * @return string
     */
    public function castSessionName($originalValue)
    {
        if ($this->session && $this->sessionName == null) {
            switch ($this->type) {
                case 'danger': return 'error'; break;
                case 'success': return 'success'; break;
                case 'info':  return 'info'; break;
                case 'warning':  return 'warning'; break;
                case 'secondary':  return 'secondary'; break;
                default: return 'secondary'; break;
            }
        }
    
        return $originalValue;
    }

    /**
     * Determine if the alert text becomes from a session flash or not
     * if the session is enabled show the alert
     * 
     * @param mixed $originalValue
     * @return mixed
     */    
    public function castAlertText($originalValue)
    {
        if ($this->session) {
            if (session()->has($this->sessionName)) {
                $this->show = true;
                return session()->get($this->sessionName);
            }else{
                $this->show = false;
            }
        }
        return $originalValue;
    }


    public function castShowAlert($originalValue)
    {
        if ($this->session) {
            return session()->has($this->sessionName);
        }

        return $originalValue;
    }
}
