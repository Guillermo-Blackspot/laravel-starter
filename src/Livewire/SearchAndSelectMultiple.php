<?php

namespace BlackSpot\Starter\Livewire;

use BlackSpot\Starter\Traits\App\HasToast;
use BlackSpot\Starter\Traits\Vendor\Livewire\HasSearch;
use Livewire\Component;
use Livewire\WithPagination;

class SearchAndSelectMultiple extends Component
{
    use HasToast, HasSearch, WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $searchAndSelectItemsPage = 1;    
    public $perPage = 15;
    public $listenerId = null;
    public $selectedItems = [];
    public $executeQuery = false;
    protected $queryString = [
        'searchAndSelectItemsPage' => ['except' => 1],
    ];
    public $showShortCuts = false;
    public $emitUp = 'setSelectedItems';
    public $selectMode = 'multiple';


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


    public function render()
    {
        return view('livewire.backend.admin.sales.contacts.search-and-select-one', [
            'items' => $this->getData()
        ]);
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

    
    public function addItem($itemToAdd) 
    {
        if ($this->selectMode == 'one' && !empty($this->selectedItems)) {
            return $this->toastError('¡Solo puedes seleccionar una opción!');
        }

        if (!isset($this->selectedItems[$itemToAdd])) {            
            $this->selectedItems[$itemToAdd] = $itemToAdd;
    
            $this->notifyParentComponent();        
        }
    }

    public function removeItem($itemToRemove)
    {
        if (isset($this->selectedItems[$itemToRemove])) {
            $this->selectedItems = array_filter($this->selectedItems, function($item) use($itemToRemove) {
                return $item != $itemToRemove;
            }, ARRAY_FILTER_USE_KEY);

            $this->notifyParentComponent();
        }
    }

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
