@php
  $name = $attributes->get('name',false);
@endphp

<div class="form-group" {!! $castedAttributes->isHidden !!}>

  {{-- LABEL --}}
  <label class="{{ $attributes->get('label-class', 'font-weight-bold') }}">
    {!! $label !!} <span class="text-danger"> {{ $castedAttributes->get('isRequired.bool') ? '*' : null }} </span>
  </label>

  {{-- ERROR MESSAGE --}}

  @if ($enableError === true)
    <span class="text-danger">
      @error($name)<span>{{ $message }}</span>@enderror
    </span>
  @endif

  {{-- INPUT --}}

  <div class="input-group">
    {{ $appendStart ?? '' }}
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
   {{ $appendEnd ?? '' }}
  </div>
</div>
