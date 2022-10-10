@php
  $exceptElementsOnInput = [
    'label-class',
    'label-jattributes',
    'error-class',
    'error-jattributes',
    'container-class',
    'container-jattributes',
    'input-jattributes',
    'placeholder',
    'hidden',
    'append',
    'prepend'
  ];
@endphp


<div class="form-group {{ $attributes->get('container-class') }}" 
      {!! $attributes->get('hidden') !!} 
      {{ $attributes->get('container-jattributes') }}>

  {{-- Label --}}
  @if ($label)  
    <label class="{{ $attributes->get('label-class') }}" {!! $attributes->get('label-jattributes') !!}>
      {!! $label !!} <span class="text-danger"> {{ $attributes->get('required') == true || $extraAttributes->has('requiredTextOnly') ? '*' : null }}</span>
    </label>
  @endif
  
  {{-- Errors --}}
  @if ($enableErrors == true)
    <span class="text-danger {{ $attributes->get('error-class') }}" {!! $attributes->get('error-jattributes') !!}>
      @error($name ?? $attributes->whereStartsWith('wire:model')->first())<span>{{ $message }}</span>@enderror
    </span>
  @endif

  {{-- INPUT --}}

  <div class="input-group">    
    @if ($attributes->has('prepend') || isset($prepend))    
      <div class="input-group-prepend">
        <span class="input-group-text">
          {!! $attributes->get('prepend', $prepend ?? '') !!}
        </span>
      </div>        
    @endif

    <input 
      type="{{ $type }}"        
      class="form-control {{ $attributes->get('class') }}"
      placeholder="{{ $attributes->get('placeholder') }} {{ $extraAttributes->get('requiredPlaceholder') }}"
      {!! ($name != false) ? "name=\"{$name}\"" : '' !!}       
      {!! ($value != null) ? "value=\"{$value}\"" : '' !!}        
      {!! $attributes->except($exceptElementsOnInput) !!}
      {!! $attributes->get('input-jattributes') !!}>    

    @if ($attributes->has('append') || isset($append))
      <div class="input-group-append">
        <span class="input-group-text">{!! $attributes->get('append', $append ?? '') !!}</span>
      </div>
    @endif
  </div>

  {{ $slot }}
  
</div>

