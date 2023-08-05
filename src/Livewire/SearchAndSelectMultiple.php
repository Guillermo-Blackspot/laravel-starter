<?php

namespace BlackSpot\Starter\Livewire;

use BlackSpot\Starter\Traits\App\HasToast;
use BlackSpot\Starter\Traits\Vendor\Livewire\HasSearch;
use Livewire\Component;
use Livewire\WithPagination;

class SearchAndSelectMultiple extends Component
{
    use HasToast, HasSearch, WithPagination;

    protected $paginationTheme       = 'bootstrap';
    public $searchAndSelectItemsPage = 1;    
    public $perPage                  = 15;
    public $listenerId               = null;
    public $selectedItems            = [];
    public $executeQuery             = false;
    public $showShortCuts            = false;
    public $emitUp                   = 'setSelectedItems';
    public $selectMode               = 'multiple';

    protected $queryString = [
        'searchAndSelectItemsPage' => ['except' => 1],
    ];    

    public function mount()
    {
        $this->executeQuery = false;
    }

    public function getData($pageQuery = null)
    {
        if ($this->inSearch == false && $this->selectedItems == []) {
            return [];
        }

        $query = $this->query();

        $this->scopeBuilder($query);

        if ($this->inSearch) {            
            $query->whereNotIn('id', $this->selectedItems);
            $this->scopeSearch($query, $this->search);
        }else{
            $query->whereIn('id', $this->selectedItems);
        }

        return $query->paginate($this->perPage,['*'], ($pageQuery ?? 'searchAndSelectItemsPage'));
    }


    /**
     * Get event listeners
     *
     * @return array
     */
    protected function getListeners()
    {
        if ($this->listenerId !== null) {
            return [
                "{$this->listenerId}.resetInputFields" => 'resetInputFields',
                "{$this->listenerId}.setSelectedItems" => 'setSelectedItems',
            ];
        }

        return [
            'resetInputFields' => 'resetInputFields',
            'setSelectedItems' => 'setSelectedItems',
        ];
    }


    public function resetInputFields()
    {    
        $this->resetExcept(
            'listenerId',
            'queryString',
            'emitUp'
        );
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetPage();
        $this->resetSearch();
    }

    protected function itemIsSelected($item)
    {
        return isset($this->selectedItems[$item]);
    }
    
    public function addItem($item) 
    {
        if ($this->selectMode == 'one' && count($this->selectedItems) > 0) {
            return $this->toastError($this->getSelectOneMessage());
        }

        if ($this->itemIsSelected($item)) {
            return ;
        }
        
        if ($this->addingItem($item) === false) {
            return ;
        }

        $this->selectedItems[$item] = $item;

        $this->itemAdded($item, $this->selectedItems[$item]);

        $this->notifyParentComponent('add');
    }

    public function removeItem($item)
    {
        if (!$this->itemIsSelected($item)) {
            return ;
        }

        if ($this->removingItem($item) === false) {
            return ;
        }

        unset($this->selectedItems[$item]);
        $this->itemRemoved($item);
        $this->notifyParentComponent('remove');
    }


    protected function getSelectOneMessage()
    {
        return '¡Solo puedes seleccionar una opción!';
    }
    
    protected function addingItem($itemKey)
    {}

    protected function itemAdded($itemKey, $data)
    {}

    protected function removingItem($itemKey)
    {}

    protected function itemRemoved($itemKey)
    {}

    /**
     * Set selected items from a event listener
     * @param array $items
     * @return void
     */
    public function setSelectedItems($items)
    {
        $this->selectedItems = $items;
        $this->executeQuery  = true;        
    }

    /**
     * Notify to parent component
     *
     * @param string $action
     * @return void
     */
    public function notifyParentComponent($action)
    {
        if ($this->listenerId !== null) {
            $this->emitUp($this->listenerId.".{$this->emitUp}", $this->selectedItems, $action);
        }else{
            $this->emitUp($this->emitUp, $this->selectedItems, $action);
        }
    }
}