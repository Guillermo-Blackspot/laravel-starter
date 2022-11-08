<?php

namespace BlackSpot\Starter\Traits\Vendor\Livewire;

/**
 * Trait for add the ability for search
 * 
 * @method void resetSearch()
 * @method void doSearch(boolean $do)
 */
trait HasSearch
{
    /**
     * The name of the input search
     * @var string
     */
    public $search = '';

    /**
     * Determine if the search is enabled
     * @var boolean
     */
    public $inSearch = false;

    /**
     * Undo search
     * @return void
     */
    public function resetSearch()
    {
        $this->doSearch(false);
    }

    public function resetPageInTheFirstSearch()
    {
        foreach ($this->paginators as $pageQuery => $value) {            
            $this->resetPage($pageQuery);
        }
    }

    public function updatedSearch($value)
    {
        if ($value != null) {
            $this->inSearch = true;
            $this->resetPageInTheFirstSearch();
        }
    }

    /**
     * Determine if do or not the search
     * @param boolean $do
     * @param mixed $toSearch
     * @return void
     */
    public function doSearch($do = true, $toSearch = '')
    {
        $this->fill([
            'inSearch' => $do == false || empty($toSearch) ? false : true,
            'search'   => $do == false ? '' : trim($toSearch)
        ]);

        if ($this->inSearch) {
            $this->resetPage();
            $this->resetPageInTheFirstSearch();            
        }
    }

}
