@php
    $randomId1 = Str::randomLetters(10);
@endphp

<div class="row justify-content-between" {!! $castedAttributes->isHidden !!}>
    <div class="col-12">
        <div class="input-group mb-1 parent input-group-sm">
            <div class="input-group-prepend" 
                 style="cursor: pointer" 
                 wire:ignore 
                 wire:click.prevent="doSearch(1, $event.target.closest('.parent').querySelector('.input-search-query').value, '{{ $wireSearch }}')" 
                 data-toggle="tooltip" 
                 data-original-title="Click para buscar" 
                 onclick="javascript:toastr.info('Buscando...')">
                <span class="input-group-text simple-filter-colors" id="{{ $randomId1 }}"><i class="fa-lg ti-search"></i></span>
            </div>
            
            <input type="text" 
                    class="form-control input-search-query" 
                    value="{{ $searchValue }}"
                    placeholder="{{ $columnsToSearch }}" 
                    aria-label="{{ $columnsToSearch }}" 
                    aria-describedby="{{ $randomId1 }}"
                    {{ $toHTML($attributes) }}
                    @if ($disableEnterKey == false)
                        wire:keydown.enter="doSearch(1,$event.target.value, '{{ $wireSearch }}')"                        
                    @endif
                >
            
            @if ($inSearch)
                <div class="input-group-prepend" style="cursor: pointer" wire:ignore wire:click.prevent="doSearch(0)" onclick="javascript:toastr.info('Deshaciendo búsqueda...')">
                    <span class="input-group-text bg-transparent text-danger b-0 pl-0 font-weight-bold" 
                          data-toggle="tooltip" 
                          data-original-title="Click para deshacer busqueda">
                          <i class="fa-lg dripicons-cross"></i> Deshacer
                    </span>
                </div>
            @endif

        </div>
    </div>   

    {{ $breakcol ?? '' }}
</div>
