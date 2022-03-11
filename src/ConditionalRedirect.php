<?php

namespace BlackSpot\Starter;

use BlackSpot\Starter\Traits\App\HasRedirects;
use Closure;
use Exception;

class ConditionalRedirect
{
    use HasRedirects;

    private $solved;
    private $conditionalRedirectResult;
    private $callbacks;


    public function __construct($redirects)
    {
        if (isset($redirects[0])) {
            $redirects = $redirects[0];
        }
        
        $this->solved = false;
        $this->conditionalRedirectResult = null;
        $this->callbacks = [
            'anyOk' => [],
            'anyFails' => [],
        ];
        $this->registerRedirects($redirects);        
    }

    /**
     * Add condition 
     * 
     * @param \Closure|boolean $condition
     * @param \Closure|string $action
     * 
     * @return \BlackSpot\Starter\ConditionalRedirect
     */
    public function when($condition, $route, $default = '')
    {
        if ($this->solved) {
            return $this;
        }

        if ($condition instanceof Closure) {
            $condition = $condition();
        }

        if ($condition) {
            if (is_string($route)) {
                $this->conditionalRedirectResult = $this->redirectToUrl($route, $default);
            }elseif ($route instanceof Closure) {
                $this->conditionalRedirectResult = $route($default);
            }else{
                throw new Exception("Action not supported!: [{$route}] ", 1);
            }
        }

        $this->solved = $condition && $this->conditionalRedirectResult != null;

        return $this;
    }


    /**
     * If any its true do something
     * 
     * @param \Closure
     * @return \BlackSpot\Starter\ConditionalRedirect
     */
    public function anyOk(Closure $callback)
    {
        $this->callbacks['anyOk'][] = $callback;
        return $this;
    }

    /**
     * If any its false do something
     * 
     * @param \Closure
     * @return \BlackSpot\Starter\ConditionalRedirect
     */
    public function anyFails(Closure $callback)
    {
        $this->callbacks['anyFails'][] = $callback;
        return $this;
    }

    public function redirect($default = '')
    {
        if ($this->solved) {
            foreach ($this->callbacks['anyOk'] as $fn) {
                $fn($this->conditionalRedirectResult);
            }
        }else{
            foreach ($this->callbacks['anyFails'] as $fn) {
                $fn();
            }
        }
        
        return $this->conditionalRedirectResult ?? $this->redirectToUrl($default);
    }


}