@php
  $name  = $attributes->get('name',false);
  $value = old($name != false ? $name : '_*_', $attributes->get('value'));
@endphp

<div class="form-group row" {!! $castedAttributes->isHidden !!}>
  {{-- ERROR MESSAGE --}}


  @if ($enableError === true)
    <span class="col-sm-12 text-danger text-right">
      @error($name)<span>{{ $message }}</span>@enderror
    </span>
  @endif

  {{-- LABEL --}}
  @if ($label != null)
    <label class="{{ $castedAttributes->get('condensedSize.label') }} col-form-label">
      {!! $label !!} <span class="text-danger"> {{ $castedAttributes->get('isRequired.bool')? '*' : null }} </span>    
    </label>
  @endif

  {{-- INPUT --}}

  <div class="{{ $castedAttributes->get('condensedSize.input') }}">
    <input type="{{ $type }}"
        class="{{ $attributes->merge(['class' => 'form-control'])->get('class') }}"
        placeholder="{{ $attributes->get('placeholder', $castedAttributes->get('isRequired.placeholder')) }}"
        {!! ($name != false) ? "name=\"{$name}\"" : '' !!}       
        {!! $toHTML($attributes) !!}
        {!! $castedAttributes->get('isRequired.html') !!}
        {!! $castedAttributes->isDisabled !!}
        {!! $castedAttributes->isReadOnly !!}
        {!! $attributes->get('raw') !!}
        {!! ($value != null) ? "value=\"{$value}\"" : '' !!}
        >
  </div>
</div>
