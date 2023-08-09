<?php

namespace BlackSpot\Starter\Livewire;

use BlackSpot\Starter\Traits\App\HasSweetAlert;
use BlackSpot\Starter\Traits\App\HasToast;
use BlackSpot\Starter\Traits\Vendor\Livewire\HasDynamicEmits;
use BlackSpot\Starter\Traits\Vendor\Livewire\HasSearch;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;

class SelectMultipleComponent extends Component
{
    use WithPagination,
        HasToast, 
        HasSweetAlert,
        HasSearch,
        HasDynamicEmits;

    /**
     * Pagination theme
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * The pagination query to show in the navigation bar
     * @var int 
     */
    public $selectMultipleComponentPage = 1;
    
    /**
     * The number of rows to show in the table
     * @var int
     */
    public $perPage = 15;

    /**
     * Show content for add items to role or show aggregated items
     * @var boolean
     */
    public $addItem = false;
            
    /**
     * The selected items
     * @param array
     */
    public $selectedItems = [];

    /**
     * Determine if execute the query to the database
     * @var boolean
     */
    public $executeQuery = false;

    /**
     * kind of Form : create|edit
     * @var string
     */
    public $formType = 'create';

    protected $queryString = [
        'selectMultipleComponentPage' => ['except' => 1],
    ];

    /**
     * Select mode 
     * "one" or "multiple"
     *
     * @var string
     */
    public $selectMode = 'multiple';

    public function mount($eventListeners = 'setSelectedItems')
    {
        $this->executeQuery   = false;
        $this->eventListeners = $eventListeners;
    }

    /**
     * Return the paginated rows to fill the table
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getData($pageQuery = null)
    {
        if ($this->executeQuery == false) {
            return [];
        }

        if ($this->addItem == false && $this->selectedItems == []) {
            return [];
        }

        $query = $this->query();

        $this->scopeBuilder($query);
        
        if ($this->addItem) {
            $query->whereNotIn('id',array_keys($this->selectedItems));
        }else{
            $query->whereIn('id',array_keys($this->selectedItems));
        }

        if ($this->inSearch) {
            $this->scopeSearch($query, $this->search);
        }

        return $query->paginate($this->perPage,['*'], ($pageQuery ?? 'selectMultipleComponentPage'));
    }

    /**
     * Validate if a item is in selected items array
     * @param int $item
     * @return bool
     */
    protected function itemIsSelected($item)
    {
        return isset($this->selectedItems[$item]);
    }


    public function updatedSelectedItems($value, $key)
    {   
        if (($dotPosition = strpos($key, '.')) !== false) {
            //$key = substr($key,0,$dotPosition);
            $this->notifyChanges('array_value_was_modified');
        }
    }


    /**
     * Add item 
     * @param int $item
     * @return void
     */
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
        $this->notifyChanges('add');
    }

    /**
     * Remove item 
     * @param int $item
     * @return void
     */
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
        $this->notifyChanges('remove');
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
     * Set the table content for: add items or show the aggregated items
     * @param string $for
     * @return void
     */
    public function setTableContentFor($for)
    {
        if ($for == 'addItem') {
            $this->addItem = true;
        }elseif ($for == 'aggregatedItems') {
            $this->addItem = false;
        }else{
            $this->addItem = false;
        }

        $this->executeQuery = true;
    }


    /**
     * Set selected items from a event listener
     * @param array $items
     * @return void
     */
    public function setSelectedItems($items)
    {
        $this->selectedItems = $items;
        $this->executeQuery = true;        
        $this->setTableContentFor('aggregatedItems');
        $this->formType = 'edit';
    }

    /**
     * Get event listeners
     *
     * @return array
     */
    protected function getListeners()
    {
        return [
            'resetInputFields' => 'resetInputFields',
            'setSelectedItems' => 'setSelectedItems',
        ];
    }

    public function resetInputFields()
    {
        $this->resetExcept([
            'eventListeners'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetPage();
        $this->resetSearch();
    }

    protected function notifyChanges($action)
    {
        $this->notifyEmits($this->selectedItems, $action);
    }
}
