<?php

namespace GuillermoRod\BladeUi\Support\Traits;

use Illuminate\Support\Str;

trait BootableTraitCastings
{
    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected function bootTraitCastings()
    {
        $class = static::class;
        foreach (class_uses_recursive($class) as $trait) {

            if ($trait == BootableTraitCastings::class || Str::contains($trait, 'Castings') == false) {
                continue;
            }

            $traitBaseName = class_basename($trait);
            $method = 'boot'.$traitBaseName;
            
            if (!in_array($trait, $this->casts)) {
                // Adding casts
                $this->{$method}('addTraitCastings', $traitBaseName); // calling to $this->addTraitCastings()
            }
        }
    }

    protected function traitIsBooted($traitName)
    {
        $traitName = class_basename($traitName);

        $bootedPropertyName = lcfirst($traitName).'Booted';        

        return $this->{$bootedPropertyName} == true;
    }

    protected function addTraitCastings($traitName, $casts = [])
    {
        if ($this->traitIsBooted($traitName)) {
            return ;
        }

        $traitName = class_basename($traitName);

        if (!isset($this->casts[$traitName])) {
            $this->casts[$traitName] = [];
        }

        foreach ($casts as $attribute => $rule) {
            $this->casts[$traitName][$attribute] = $rule;
        }
        
        $bootedPropertyName = lcfirst($traitName).'Booted';

        $this->{$bootedPropertyName} = true;
    }

    protected function addSameTraitCastingsToAttributes($traitName, $attributes = [], $castRule)
    {
        if ($this->traitIsBooted($traitName)) {
            return ;
        }

        $traitName = class_basename($traitName);

        if (!isset($this->casts[$traitName])) {
            $this->casts[$traitName] = [];
        }

        foreach ($attributes as $attribute) {
            $this->casts[$traitName][$attribute] = $castRule;
        }
        
        $bootedPropertyName = lcfirst($traitName).'Booted';

        $this->{$bootedPropertyName} = true;
    }
}