<div class="{{ $attributes->merge(['class' => 'mt-2 table-responsive bg-white rounded-sm'])->get('class') }}">
    {{-- @if ($isReady) --}} 
        <table class="table table-hover mb-4" {{ $castedAttributes->isHidden }} {!! $toHTML($attributes) !!}>
            <thead class="thead-light">           
                @if ($castedAttributes->includeTr) <tr> @endif
                    {{ $head }}
                @if ($castedAttributes->includeTr) </tr> @endif
            </thead>                                
            <tbody>
                {{ $body }}
            </tbody>
        </table>
        @isset($pagination)            
            <div class="d-flex justify-content-start">
                {{ $pagination }}
            </div>
        @endisset
    {{--
        @else 
            <x-loading class="row col-12" />
        @endif 
    --}}
</div>