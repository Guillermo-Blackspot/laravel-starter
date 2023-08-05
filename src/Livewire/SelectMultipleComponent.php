<?php

namespace BlackSpot\Starter\Livewire;

use App\Models\User;
use BlackSpot\Starter\Traits\App\HasSweetAlert;
use BlackSpot\Starter\Traits\App\HasToast;
use BlackSpot\Starter\Traits\Vendor\Livewire\HasSearch;
use Livewire\Component;
use Livewire\WithPagination;

class SelectMultipleComponent extends Component
{
    use WithPagination,
        HasToast, 
        HasSweetAlert,
        HasSearch;

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
     * The listener id for all events that owns to the component
     * @deprecated but still working, not recomendable
     * @var string|null
     */
    public $listenerId = null;
    
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

    protected $parentEventListener = 'setSelectedItems';

    public $selectMode = 'multiple';

    public function mount()
    {
        $this->executeQuery = false;
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
            $this->notifyParentComponent('array_value_was_modified');
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
        $this->notifyParentComponent('add');
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
        if ($this->listenerId != null) {
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
        $this->resetExcept([            
            'listenerId'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetPage();
        $this->resetSearch();
    }

    /**
     * Notify to parent component
     *
     * @param string $action
     * @return void
     */
    public function notifyParentComponent($action)
    {
        if ($this->listenerId != null) {
            $this->emitUp($this->listenerId.'.'.$this->parentEventListener, $this->selectedItems, $action);
        }else {
            $this->emitUp($this->parentEventListener, $this->selectedItems, $action);
        }
    }

}
