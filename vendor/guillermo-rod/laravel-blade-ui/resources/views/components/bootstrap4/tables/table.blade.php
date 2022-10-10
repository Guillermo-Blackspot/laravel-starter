@php
$exceptElements = [
    'container-class',
    'container-jattributes',
    //
    'hidden',
    //
    'thead-class',
    'thead-jattributes',
    //
    'tfoot-class',
    'tfoot-jattributes',
    //
    'tbody-class',
    'tbody-jattributes',
    //
    'pagination-class',
    'pagination-jattributes',
];
@endphp

<div class="mt-2 table-responsive {{ $attributes->get('container-class') }}" 
    {!! $attributes->get('container-jattributes') !!}
    {{ $attributes->get('hidden') == true ? 'hidden=hidden' : '' }}
    >

    <table class="table mb-4 {{ $attributes->get('class') }}" {!! $attributes->except($exceptElements) !!}>        
        @isset($head)            
            <thead class="thead-light {{ $attributes->get('thead-class') }}" {!! $attributes->get('thead-jattributes') !!}>
                {!! $head !!}
            </thead>                                
        @endisset

        <tbody class="{{ $attributes->get('tbody-class') }}" {!! $attributes->get('tbody-jattributes') !!}>
            {!! $body !!}
        </tbody>

        @isset($footer)         
            <tfoot class="{{ $attributes->get('tfoot-class') }}" {!! $attributes->get('tfoot-jattributes') !!}>
                {!! $footer !!}
            </tfoot>                                
        @endisset
    </table>

    @isset($pagination)            
        <div class="d-flex justify-content-start w-100 {{ $attributes->get('pagination-class') }}" {!! $attributes->get('pagination-jattributes') !!}>
            {!! $pagination !!}
        </div>
    @endisset    
</div>