<?php

namespace BlackSpot\Starter;

use BlackSpot\Starter\Traits\App\HasRedirects;
use Closure;
use Exception;

class ConditionalRedirect
{
    use HasRedirects;

    private $conditions = [];
    private $callbacks  = [
        'anyOk'    => [],
        'anyFails' => [],
    ];

    public function __construct($redirects)
    {
        if (isset($redirects[0])) {
            $redirects = $redirects[0];
        }

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
        $conditionResult = $condition instanceof \Closure ? $condition() : $condition;

        $this->conditions[] = [
            'condition' => $conditionResult,
            'route'     => $route, 
            'default'   => $default
        ];

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

    private function executeOkCallbacks(&$route = '')
    {
        foreach ($this->callbacks['anyOk'] as $fn) {
            $fn($route);
        }
    }
    
    private function executeFailCallbacks()
    {
        foreach ($this->callbacks['anyFails'] as $fn) {
            $fn();
        }
    }

    private function assertConditionedRedirectionIsValid($route)
    {
        if ($route !== null && $route !== '' && ! is_string($route) && ! ($route instanceof Closure)) {
            throw new Exception("Action not supported!: [{$route}] ", 1);
        }
    }

    private function resolveConditionedRedirection($route, $default = '')
    {
        $this->assertConditionedRedirectionIsValid($route);

        if (is_string($route)) {
            return $this->redirectToUrl($route);
        }elseif ($route instanceof Closure) {
            return $route($default);
        }
    }


    public function redirect($default = '')
    {
        $redirectResult = collect($this->conditions)->firstWhere('condition', true);

        // FAILS
        // RETURNS DEFAULT OR NULL
        if ($redirectResult == null) {
            $this->executeFailCallbacks();
            $this->assertConditionedRedirectionIsValid($default);
            return $this->redirectToUrl($default);
        }

        // OK
        $redirect = $this->resolveConditionedRedirection(
            $redirectResult, $default
        );

        $this->executeOkCallbacks($redirect);

        return $redirect;
    }
}