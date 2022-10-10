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
        if ($this->listenerId == null) {
            $this->listenerId = str_replace('\\','_',self::class);
        }

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
        return [
            "{$this->listenerId}.resetInputFields" => 'resetInputFields',
            "{$this->listenerId}.setSelectedItems" => 'setSelectedItems',
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

    private function itemIsSelected($item)
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
        
        $this->addingItem($item);

        $this->selectedItems[$item] = $item;

        $this->itemAdded($item, $this->selectedItems[$item]);

        $this->notifyParentComponent();
    }

    public function removeItem($item)
    {
        if (!$this->itemIsSelected($item)) {
            return ;
        }

        $this->removingItem($item);
        unset($this->selectedItems[$item]);
        $this->itemRemoved($item);
        $this->notifyParentComponent();
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

    public function notifyParentComponent()
    {
        $this->emitUp($this->listenerId.".{$this->emitUp}", $this->selectedItems);
    }

}
