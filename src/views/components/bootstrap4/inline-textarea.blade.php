@php
  $attributesCollection = $attributesToCollect($attributes);
  $parsedRequired       = $parseRequiredAttribute($attributesCollection->get('required'));
  $parsedCondensed      = $parseCondensedAttribute($condensed, $condensedSize, $label);
  $name                 = $attributesCollection->get('name',false);
  $value                = old($name != false ? $name : '_*_', $attributes->get('value'));
@endphp

<div class="form-group row" {!! $isHidden($attributesCollection) !!}>

  {{-- ERROR MESSAGE --}}

  @if ($enableError === true)
    <span class="col-sm-12 text-danger text-right">
      @error($name)<span>{{ $message }}</span>@enderror
    </span>
  @endif

  {{-- LABEL --}}
  @if ($label != null)
    <label class="{{ $parsedCondensed['label'] }} col-form-label">
      {!! $label !!} <span class="text-danger"> {{ ($parsedRequired['bool']) ? '*' : null }} </span>
    </label>
  @endif

  {{-- INPUT --}}

  <div class="{{ $parsedCondensed['input'] }}">
    <textarea
           class="{{ $attributes->merge(['class' => 'form-control'])->get('class') }}"
           placeholder="{{ $attributesCollection->get('placeholder',$parsedRequired['placeholder']) }}"
           {!! ($name != false) ? "name=\"{$name}\"" : '' !!}       
           {!! $toHTML($extends($attributesCollection)) !!}
           {!! $isDisabled($attributesCollection) !!}
           {!! $isRequired($parsedRequired) !!}>{{ $value}}</textarea>
  </div>
</div>
