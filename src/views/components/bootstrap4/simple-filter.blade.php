@php
    $randomId1 = Str::randomLetters(10);
@endphp

<div class="justify-content-between align-items-center mb-2 w-100">
    <div class="row" style="row-gap: 10px;">

        <div class="col">
            <div class="input-group --parent">    
                {{-- <div class="input-group-prepend" 
                     style="cursor: pointer"
                     wire:click.prevent="doSearch(1, $event.target.closest('.--parent').querySelector('.input-search-query').value)" 
                     title="Click para buscar">
                    <span class="input-group-text simple-filter-colors" style="border: none;" id="{{ $randomId1 }}"><i class="fa-lg ti-search"></i></span>
                </div>             --}}
    
                <input type="text" 
                    class="form-control input-search-query border-left-0" 
                    placeholder="{{ $attributes->get('placeholder', 'Buscar..') }}" 
                    {{-- $attributes->has('search-value')?"value='$attributes->get('search-value')'":'' --}}
                    {{ $attributes->has('input-name') ? "name='{$attributes->get('input-name')}'" : ''}}        
                    wire:model.debounce.500ms="{{ $attributes->has('wire-input-model') ? $attributes->get('wire-input-model') : 'search' }}"
                    >
    
                @if ($inSearch)
                    <div class="input-group-prepend" 
                        style="cursor: pointer" 
                        wire:click.prevent="doSearch(0)"
                        >
                        <span class="input-group-text bg-transparent text-danger b-0 pl-0" title="Click para deshacer busqueda">
                              <i class="fa-lg dripicons-cross"></i> Deshacer
                        </span>
                    </div>
                @endif
            </div>
        </div>    
        
        @if ($attributes->has('exclude-per-page') == false)
            <div class="col-auto">
                {{-- <label class="col-form-label col-form-label-sm">Mostrar: </label> --}}
                <select 
                    class="form-control simple-filter-colors" 
                    wire:model="{{ $attributes->has('wire-per-page-model') ? $attributes->get('wire-per-page-model') : 'perPage' }}"
                    style="border: none">
                    @foreach (explode(',', $attributes->get('per-page', '15,30,50,100')) as $pageCount)                            
                        <option value="{{ $pageCount }}">{{ $pageCount }}</option>
                    @endforeach
                </select> 
            </div>
        @endif
    
        @isset($actions)
            <div class="{{ $actions->attributes->has('new-line') ? 'col-md-12' : 'col-md-auto' }} col-12 {{ $actions->attributes->get('class') }}">
                <div class="btn-group">                    
                    {{ $actions ?? '' }}
                </div>
            </div>            
        @endisset
        
        {{-- Deprecated: $actionsLeft --}}
        {{-- Deprecated: $breakcol --}}

        {{ $slot ?? '' }}
    </div>
</div>
