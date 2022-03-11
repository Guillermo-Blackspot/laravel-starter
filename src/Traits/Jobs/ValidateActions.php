<?php
namespace BlackSpot\Starter\Traits\Jobs;

trait ValidateActions
{
    
    public $action;

    public function isUpdate()
    {
        return $this->action == 'edit' || $this->action == 'update';
    }

    public function isCreate()
    {
        return $this->action == 'create' || $this->action == 'store' || $this->action == 'new';;

    }

}
