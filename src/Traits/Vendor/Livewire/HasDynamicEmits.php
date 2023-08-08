<?php 

namespace BlackSpot\Starter\Traits\Vendor\Livewire;

trait HasDynamicEmits
{
    /**
     * Event listener used to notify
     * interactions
     *
     * @var string|array
     */
    public $eventListeners = [];

    /**
     * Match dynamic arguments on listener path
     * listener.{argument1}.{argument2}.{argument.with_nested}
     *
     * @param array &$matches
     * @param string $listener
     * @return int matches quantity
     */
    protected function matchEmitArgumentsFromListener(&$matches, $listener)
    {
        return preg_match_all('/\{(.*?)\}/s', $listener, $matches);
    }

    /**
     * Replace from eventListeners
     * the dynamic arguments to 
     * build the emit listener path
     *
     * @param string $emitListener
     * @return string
     */
    protected function replaceEmitArguments($emitListener)
    {
        $expressions = [];

        if ($this->matchEmitArgumentsFromListener($expressions, $emitListener) == 0) return $emitListener;

        return str_replace(
            $expressions[0], 
            $this->collectEventListenerArguments($expressions[1]), 
            $emitListener
        );
    }

    /**
     * Collect the listener arguments 
     * from the component
     *
     * @param array $properties
     * @return array
     */
    protected function collectEventListenerArguments(array $properties)
    {
        $values = [];

        foreach ($properties as $property) {
            if (($componentValue = data_get($this, $property)) != null) {
                $values[] = $componentValue;
                return ;
            }
            throw new \Exception('Some dynamic argument from event listeners of livewire component is null');
        }

        return $values;
    }

    /**
     * Notify to parent component
     *
     * @param mixed $emitArguments
     * @return void
     */
    protected function notifyEmits(...$emitArguments)
    {
        if (is_string($this->eventListeners)) {
            return $this->emit($this->eventListeners, ...$emitArguments);
        }
        else if (is_array($this->eventListeners)) {            

            $emitGroups = collect($this->eventListeners);        
            $emits      = $emitGroups->only('emits');
            $emitsTo    = $emitGroups->only('emitsTo');
            $emitsUp    = $emitGroups->only('emitsUp');
            $emitsSelf  = $emitGroups->only('emitsSelf');
            
            // Simple emits
            // [listener, listener]
            if ($emits->isNotEmpty()) {
                collect($emits['emits'])->each(fn ($emit) => $this->emit($this->replaceEmitArguments($emit), ...$emitArguments));
            }
            
            // Emit to
            // [ 
            //    [component, listener], 
            //    [component, listener], 
            // ]
            //
            if ($emitsTo->isNotEmpty()) {
                collect($emitsTo['emitsTo'])->each(fn ($emitTo) => $this->emitTo($emitTo[0], $this->replaceEmitArguments($emitTo[1]), ...$emitArguments));
            }

            // Emit Up
            // [listener, listener]
            //
            if ($emitsUp->isNotEmpty()) {
                collect($emitsUp['emitsUp'])->each(fn ($emitUp) => $this->emitUp($this->replaceEmitArguments($emitUp), ...$emitArguments));
            }

            // Emit Self
            // [listener, listener]
            //
            if ($emitsSelf->isNotEmpty()) {
                collect($emitsSelf['emitsSelf'])->each(fn ($emitSelf) => $this->emitSelf($this->replaceEmitArguments($emitSelf), ...$emitArguments));
            }
        }
    }
}