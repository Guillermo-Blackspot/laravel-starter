
<div {{ $attributes->merge(['class' => 'alert alert-'.$type.' '.($castedAttributes->show && $castedAttributes->dismiss ? 'alert-dismissible' : '')]) }} 
    role="alert" 
    style="{{ $castedAttributes->show ? '': 'display:none;' }}"
    {!! $castedAttributes->get('isHidden') !!}
    {!! $toHTML($attributes) !!}
    >
    
    @if ($title != null)
        <h4 class="alert-heading">{{ $title }}</h4>       
        <hr> 
    @endif

    {!! $castedAttributes->text !!}

    {!! $slot ?? '' !!}

    @if ($castedAttributes->dismiss)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif
</div>