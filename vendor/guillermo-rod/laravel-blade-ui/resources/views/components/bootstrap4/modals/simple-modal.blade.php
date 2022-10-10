@php
  $exceptElements = [
    'container-class',
    'container-jattributes',
    //
    'dialog-class',
    'dialog-jattributes',
    //
    'content-class',
    'content-jattributes',
    //
    'header-class',
    'header-jattributes',
    //
    'title-class',
    'title-jattributes',
    //
    'close-class',
    'close-jattributes',
    //
    'body-class',
    'body-jattributes',
    //
    'footer-class',
    'footer-jattributes',
  ];
@endphp

{{-- Container --}}
<div 
    class="modal fade {{ $attributes->get('container-class') }}"
    id="{{ $id }}"
    tabindex="-1"
    role="dialog"
    aria-labelledby="{{ $id }}--labelledby"
    aria-hidden="true"
    {{ $attributes->get('container-jattributes') }}>
  
    {{-- Dialog --}}
    <div role="document"
        class="modal-dialog {{ $attributes->get('dialog-class') }}"
        {{ $attributes->get('dialog-jattributes') }}>
        
        {{-- Content --}}
        <div class="modal-content p-2 {{ $attributes->get('content-class') }}"
            {{ $attributes->get('content-jattributes') }}>
            
            {{-- Header --}}
            @if ($attributes->has('title') || isset($title))                
                <div 
                    class="modal-header py-3 p-2 {{ $attributes->get('header-class') }}"
                    {{ $attributes->get('header-jattributes') }}
                    >
                    {{-- Title --}}
                    <div id="{{ $id }}--labelledby"
                        class="modal-title h5 mb-0 {{ $attributes->get('title-class') }}"
                        {{ $attributes->get('title-jattributes') }}>
                        {!! $attributes->get('title', $title ?? '') !!}
                    </div>

                    {{-- Close button --}}
                    <button type="button" 
                        data-dismiss="modal" 
                        aria-label="Close"
                        class="close {{ $attributes->get('close-class') }}" 
                        {{ $attributes->get('close-jattributes') }}>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Modal body --}}
            <div class="modal-body p-1 {{ $attributes->get('body-class') }}"
                {{ $attributes->get('body-jattributes') }}>
                {{ $slot ?? '' }}
            </div>

            {{-- Footer --}}
            @if ($attributes->has('footer') || isset($footer))
                <div 
                    class="modal-footer {{ $attributes->get('footer-class') }}"
                    {{ $attributes->get('footer-jattributes') }}>
                    {!! $attributes->get('footer', $footer ?? '') !!}
                </div>
            @endif

        </div>
    </div>
</div>
