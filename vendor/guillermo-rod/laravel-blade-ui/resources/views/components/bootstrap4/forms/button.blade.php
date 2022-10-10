
<button type="{{ $type }}" style="display:flex; gap: 4px; {{ $attributes->get('style') }}" class="btn {{ $attributes->get('class') }}" {{ $attributes->except(['class','style']) }}>
    @if ($icon) 
        <i class="{{ $icon }}"></i>  
    @elseif ($htmlIcon)
        {!! $htmlIcon !!}
    @endif    
    
    @if ($text)
        <p class="m-0">{{ $text }}</p>    
    @endif

    {!! $slot !!}
</button>