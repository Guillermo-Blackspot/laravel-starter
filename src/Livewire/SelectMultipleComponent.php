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
        if ($this->listenerId == null) {
            $this->listenerId = str_replace('\\','_',self::class);
        }

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
     * Notify changes to components (nested, parent, self)
     *
     * @param bool $success
     * @return bool $success
     */
    public function notifyChanges($success)
    {
        $this->simpleToast($success);

        if ($success) {      
            if ($this->formType == 'create') {
                $this->resetInputFields();
            }

            $this->emitUp("{$this->listenerId}.freshRows");
        }
        return $success;
    }

    /**
     * Validate if a item is in selected items array
     * @param int $item
     * @return boolean
     */
    public function itemIsSelected($item)
    {
        return isset($this->selectedItems[$item]);
    }


    public function updatedSelectedItems($value, $key)
    {   
        if (($dotPosition = strpos($key, '.')) !== false) {
            //$key = substr($key,0,$dotPosition);
            $this->emitUp($this->listenerId.'.'.$this->parentEventListener, $this->selectedItems, 'array_value_was_modified');
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

        $this->addingItem($item);

        $this->selectedItems[$item] = $item;

        $this->itemAdded($item, $this->selectedItems[$item]);

        $this->emitUp($this->listenerId.'.'.$this->parentEventListener, $this->selectedItems, 'add');    

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

        $this->removingItem($item);

        unset($this->selectedItems[$item]);

        $this->itemRemoved($item);
            
        $this->emitUp($this->listenerId.'.'.$this->parentEventListener, $this->selectedItems, 'remove');
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

        $this->emitUp($this->listenerId.'.freshParentComponent');
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
            "{$this->listenerId}.resetInputFields" => 'resetInputFields',
            "{$this->listenerId}.setSelectedItems" => 'setSelectedItems',
        ];
    }

}
