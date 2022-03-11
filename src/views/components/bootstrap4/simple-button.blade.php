
<a href="{{ $link ?? 'javascript:void(0);' }}" {!! $castedAttributes->isHidden !!} {{ $attributes->get('target',null) ? 'target='.$attributes->get('target',null) : '' }}>
    <button type="{{ $type }}" 
        class="{{ $attributes->merge(['class' => 'btn'])->get('class') }}" 
        {!! $castedAttributes->isDisabled !!} 
        {!! $toHTML($attributes) !!}
        >
        @if ($icon != null) <i class="{{ $icon }}"></i> @endif {{ $text ?? $slot }}
    </button>
</a>