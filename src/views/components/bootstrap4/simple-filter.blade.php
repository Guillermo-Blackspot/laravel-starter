@php
    $randomId1 = Str::randomLetters(10);
@endphp

<div class="row justify-content-between">
    <div class="col">
        <div class="input-group mb-1 parent">
            <div class="input-group-prepend" 
                 style="cursor: pointer" 
                 wire:ignore 
                 wire:click.prevent="doSearch(1, $event.target.closest('.parent').querySelector('.input-search-query').value, '{{ $wireSearch }}')" 
                 title="Click para buscar">
                <span class="input-group-text simple-filter-colors" id="{{ $randomId1 }}"><i class="fa-lg ti-search"></i></span>
            </div>
            

            <input type="text" 
                    class="form-control input-search-query" 
                    value="{{ $searchValue }}"
                    placeholder="{{ $columnsToSearch }}" 
                    aria-label="{{ $columnsToSearch }}"
                    wire:model.debounce.500ms="{{ $wireSearch }}"
                    aria-describedby="{{ $randomId1 }}"
                    wire:keydown.enter="doSearch(1,$event.target.value, '{{ $wireSearch }}')"
                >
            
            @if ($inSearch)
                <div class="input-group-prepend" style="cursor: pointer" wire:ignore wire:click.prevent="doSearch(0)">
                    <span class="input-group-text bg-transparent text-danger b-0 pl-0 font-weight-bold" title="Click para deshacer busqueda">
                          <i class="fa-lg dripicons-cross"></i> Deshacer
                    </span>
                </div>
            @endif

        </div>
    </div>        
    <div class="col-auto">
        <div class="form-group row mb-1">

            {{ $actionsLeft ?? '' }}

            @if ($attributes->has('excludePerPage') == false)                
                <div class="col-auto row">
                    <label class="col-sm-5 col-form-label col-form-label-sm">Mostrar: </label>                                            
                    <div class="col-auto">
                        <select class="form-control simple-filter-colors rounded-sm" wire:model="perPage">
                            @foreach (explode(',', $attributes->get('perPage', '15,30,50,100')) as $pageCount)                            
                                <option value="{{ $pageCount }}">{{ $pageCount }}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>            
            @endif
            
            <div class="btn-group col-auto">
                {{ $actions ?? '' }}
            </div>
        </div>
    </div>

    {{ $breakcol ?? '' }}


</div>
