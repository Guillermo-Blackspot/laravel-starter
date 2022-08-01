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
                 title="Click para buscar" 
                 onclick="javascript:toastr.info('Buscando...')">
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
                <div class="input-group-prepend" style="cursor: pointer" wire:ignore wire:click.prevent="doSearch(0)" onclick="javascript:toastr.info('Deshaciendo búsqueda...')">
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
            
            <div class="col-auto row">
                <label class="col-sm-5 col-form-label col-form-label-sm">Mostrar: </label>                                            
                <div class="col-auto">
                    <select class="form-control simple-filter-colors rounded-sm" wire:model="{{ $wirePages }}">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> 
                </div>
            </div>            
            <div class="btn-group col-auto">
                {{ $actions ?? '' }}
            </div>
        </div>
    </div>

    {{ $breakcol ?? '' }}


</div>
