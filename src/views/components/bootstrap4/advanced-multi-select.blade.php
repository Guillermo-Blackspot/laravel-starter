<div class="form-group select-multiple" {!! $castedAttributes->isHidden !!} {{-- wire:loading.class="disable-content, disable-all-form-inputs" --}} tabindex="0">
    <label class="font-weight-bold">
      {!! $label !!} 
      <span class="text-primary font-weight-light" wire:loading wire:target="{{ $fnToggle }}, gotoPage">Espere...</span>
    </label>          
    <input type="text" class="form-control input-filtering-ul" {!! $castedAttributes->isDisabled !!} placeholder="{{ $placeholder }}" onclick="filterUlOptionsHideToggle(this)" oninput="filterUlOptionsStartFiltering(this)">  

    @isset($fnSearch)        
        <button type="button" class="btn btn-outline-primary btn-search-if-not-exists" style="display: none" wire:click.prevent="{{ $fnSearch }}($event.target.closest('.select-multiple').querySelector('.input-filtering-ul').value)">
            Buscar
        </button>
    @endisset

    <ul class="form-row bg-white p-0 m-0 mt-1 border border-top-0" 
        style="list-style: none; max-height: 340px; overflow-y: scroll !important; overflow-x: hidden; width: 100%" 
        wire:loading.attr="hidden"
        {{ $toHTML($attributes) }}
        >
        @foreach ($options as $option)        
            @php
                $optionTxtLabel = '';
                $optionValue    = $option[$trackBy];
                $isSelected     = isset($selected[$optionValue]);

                if ($optionLabel != null) {
                    if (Str::contains($optionLabel,',')) {
                        $optionTxtLabel = implode(' ', Arr::only(to_array($option), explode(',', $optionLabel)));
                    }else{
                        $optionTxtLabel = $option[$optionLabel];
                    }
                }
            @endphp
        
            <li class="col-12 hover-toggling-selected c-pointer p-2 {{ $isSelected ? 'selected' : '' }}" 
                wire:key="advanced-multiselect-{{ $key }}-{{ $optionValue }}"
                style="{{ $isSelected ? '' : 'display: none' }}" 
                data-track-by="{{ $optionValue }}" 
                data-option-label="{{ $optionTxtLabel }}" 
                wire:click.prevent="{{ $fnToggle }}('{{ $optionValue }}')">                

                @isset($customOption)
                    {!! eval('?>'.Blade::compileString($customOption)) !!}
                @else
                    <span class="row">
                        <span class="col-12">{{ $optionTxtLabel }}</span> 
                        <!--span class="col-auto font-weight-light text-right" style="color: #000"> { $isSelected ? 'Quitar' : 'Seleccionar' }</!--span> <!--button class="btn btn-sm btn-outline-success" type="button">+</button-->
                    </span>
                @endisset

            </li>
        @endforeach
        @isset($pagination)
            <li class="col-12 p-1 helper">
                <div class="d-flex justify-content-start">
                    {{ $pagination }}
                </div>
            </li>
        @endisset
    </ul>
</div>