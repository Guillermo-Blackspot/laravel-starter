@php
  $name  = $attributes->get('name',false);
  $value = old($name != false ? $name : '_*_', $attributes->get('value'));
@endphp

<div class="form-group" {!! $castedAttributes->isHidden !!}>

  {{-- LABEL --}}

  @if ($label)
    <label class="font-weight-bold">
      {!! $label !!} <span class="text-danger"> {{ $castedAttributes->get('isRequired.bool') ? '*' : null }} </span>
    </label>      
  @endif

  {{-- ERROR MESSAGE --}}

  @if ($enableError === true)
    <span class="text-danger">
      @error($name)<span>{{ $message }}</span>@enderror
    </span>
  @endif

  {{-- INPUT --}}

  <textarea class="{{ $attributes->merge(['class' => 'form-control'])->get('class') }}"             
            placeholder="{{ $attributes->get('placeholder', $castedAttributes->get('isRequired.placeholder')) }}"
            {!! ($name != false) ? "name=\"{$name}\"" : '' !!}  
            {!! $toHTML($attributes) !!}
            {!! $castedAttributes->get('isRequired.html') !!}
            {!! $castedAttributes->isDisabled !!}
            {!! $castedAttributes->isReadOnly !!}
            {!! $attributes->get('raw') !!}
          >{{ $value }}</textarea>
</div>
