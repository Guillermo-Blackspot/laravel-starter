<?php

namespace BlackSpot\Starter\Livewire;

interface BuilderMethods {


    /**
     * Get the query builder
     * 
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query();

    /**
     * Add selects or anything more in the compose of the query
     * 
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     * @return void
     */
    public function scopeBuilder($query);

    /**
     * Add the wheres for search
     * 
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     * @param mixed 
     * @return void
     */
    public function scopeSearch($query, $searchValue);

    /**
     * Reset component attributes
     * 
     * @return void
     */
    public function resetInputFields();
}