@php
  $name = $attributes->get('name',false);
@endphp

<div class="form-group row" {!! $castedAttributes->isHidden !!}>


  @if ($enableError === true)
    <span class="col-sm-12 text-danger text-right">
      @error($name)<span>{{ $message }}</span>@enderror
    </span>
  @endif


  @if ($label != null)
    <label class="{{ $castedAttributes->condensedSize['label'] }} col-form-label">
      {!! $label !!} <span class="text-danger"> {{ $castedAttributes->get('isRequired.bool') ? '*' : null }} </span>
    </label>
  @endif



  <div class="{{ $castedAttributes->condensedSize['input'] }}">
    <select class="{{ $attributes->merge(['class' => 'form-control'])->get('class') }}"
            {!! ($name != false) ? "name=\"{$name}\"" : '' !!}       
            {!! $toHTML($attributes) !!}          
            {!! $castedAttributes->get('isRequired.html') !!}
            {!! $castedAttributes->isDisabled !!}
            {!! $castedAttributes->isReadOnly !!}
            {!! $attributes->get('raw') !!}
            >
          {{ $slot ?? '' }}
    </select>
  </div>
</div>
