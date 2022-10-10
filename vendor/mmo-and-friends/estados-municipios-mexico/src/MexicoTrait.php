<?php
namespace MmoAndFriends\Mexico;

trait MexicoTrait
{
    public function estados($type = 'object')
    {
        return $this->getStates($type);
    }

    public function municipiosDeEstado($estado = null, $type = 'object')
    {
        return $this->getMunicipalitiesOf($estado, $type);
    }

    public function getStates($type = 'object')
    {
        return Mexico::getStates($type);
    }

    public function getMunicipalitiesOf($state = null, $type = 'object')
    {
        return Mexico::getMunicipalitiesOf($state, $type);
    }
}
