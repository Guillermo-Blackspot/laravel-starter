@php
    $exceptElements = [
        'role',
        'title',
        'jattributes',
        'heading-class',
        'heading-jattributes',
        'close-button-class',
        'close-button-jattributes',
        'hidden'
    ];

    $showAlert      = true;
    $flashTextValue = null;

    if ($flash !== null) {
        $showAlert      = session()->has($flash);
        $flashTextValue = ($showAlert) ? session()->get($flash) : null ;
    }
@endphp


<div role="alert" 
        {{ $attributes->except($exceptElements)->merge(['class' => 'alert ']) }} 
        {{ $attributes->get('jattributes') }}
        {{ $showAlert == false ? 'hidden=hidden' : '' }}
        >
    
    @if ($closeButton == true)
        <button type="button" class="close {{ $attributes->get('close-button-class') }}" {{ $attributes->get('close-button-jattributes') }} data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif

    @if ($attributes->has('title') || isset($title))
        <div class="alert-heading {{ $attributes->get('heading-class') }}" {{ $attributes->get('heading-jattributes') }}>
            @isset($title) 
                {{ $title }}
            @else
                <p class="h4">{{ $attributes->get('title') }}</p><hr>
            @endisset
        </div>
    @endif

    @if ($attributes->has('text') || isset($text))
        {{ $attributes->get('text', $text ?? '') }}
    @endif

    {!! $flashTextValue !!}

    {{ $slot }}
</div>