<?php
namespace BlackSpot\Starter;

use Illuminate\Support\Arr;
use ArrayAccess;

class ArrayableClass implements ArrayAccess
{
    
    public $data = [];

    public function __construct($data = []) {
        $this->data = $data;
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($key)
    {
        $this->forget($key);
    }

    public function __call($method, $parameters)
    {
        return Arr::{$method}($this->data , ...$parameters);
    }

    public function __get($name)
    {
        return $this->get($name,null);
    }
}
