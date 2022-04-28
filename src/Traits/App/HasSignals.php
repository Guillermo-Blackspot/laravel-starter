<?php
namespace BlackSpot\Starter\Traits\App;

use Closure;

trait HasSignals
{
    public $signals;

    /**
     * Push callbacks if not exists
     * 
     * @param mixed $signal
     * @param Closure $callback
     * @return self
     */
    public function pushSignal($signal, Closure $callback)
    {
        if (isset($this->signals[$signal]) == false) {
            $this->signals[$signal] = [];
        }
        $this->signals[$signal][] = $callback;

        return $this;
    }


    /**
     * Call the callbacks of the step
     *
     * @param mixed $signal
     * @param array|null $args
     * @return self
     */
    public function callSignal($step, $args = [])
    {
        if (isset($this->signals[$step]) == false) {
            return 0;
        }

        foreach ($this->signals[$step] as $callback) {
            $callback(...$args);
        }

        return $this;
    }
}