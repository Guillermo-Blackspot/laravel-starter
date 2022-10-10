<div {{ $attributes->merge(['style' =>  'position:relative; width:'.(in_array($type,['clock','bars','circle']) ? '45px;' : '60px;')]) }}>
@switch($type)
    @case('clock')
        <!-- Clock -->
        <svg style="vertical-align: middle;" version="1.1" 
            xmlns="http://www.w3.org/2000/svg" 
            xmlns:xlink="http://www.w3.org/1999/xlink" 
            x="0px" 
            y="0px"
            viewBox="0 0 100 100" 
            enable-background="new 0 0 100 100" 
            xml:space="preserve">
            <circle fill="none" stroke="{{ $color }}" stroke-width="4" stroke-miterlimit="10" cx="50" cy="50" r="48"/>
            <line fill="none" stroke-linecap="round" stroke="{{ $color }}" stroke-width="4" stroke-miterlimit="10" x1="50" y1="50" x2="85" y2="50.5">
                <animateTransform 
                    attributeName="transform" 
                    dur="2s"
                    type="rotate"
                    from="0 50 50"
                    to="360 50 50"
                    repeatCount="indefinite" />
            </line>
            <line fill="none" stroke-linecap="round" stroke="{{ $color }}" stroke-width="4" stroke-miterlimit="10" x1="50" y1="50" x2="49.5" y2="74">
                <animateTransform 
                    attributeName="transform" 
                    dur="15s"
                    type="rotate"
                    from="0 50 50"
                    to="360 50 50"
                    repeatCount="indefinite" />
            </line>
        </svg>
    @break
    @case('circle')
        <!-- Circle -->
        <svg style="vertical-align: middle;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <circle fill="none" stroke="{{ $color }}" stroke-width="8" cx="50" cy="50" r="40" style="opacity: 0.3;"></circle>
            <circle fill="{{ $color }}" stroke="{{ $color }}" stroke-width="3" cx="12" cy="54" r="10">
                <animateTransform attributeName="transform" dur="2s" type="rotate" from="0 50 48" to="360 50 52" repeatCount="indefinite"></animateTransform>        
            </circle>
        </svg>
        @break
    @case('dots-fading')
        <!-- Dots fading -->
        <svg style="vertical-align: middle;" version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <circle fill="{{ $color }}" stroke="none" cx="6" cy="50" r="6">
                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"/>    
            </circle>
            <circle fill="{{ $color }}" stroke="none" cx="26" cy="50" r="6">
                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite"  begin="0.2"/>       
            </circle>
            <circle fill="{{ $color }}" stroke="none" cx="46" cy="50" r="6">
                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite"  begin="0.3"/>     
            </circle>
        </svg>
        @break
    @case('dots-jumping')
        <!-- Dots jumping -->
        <svg style="vertical-align: middle;" version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <circle fill="{{ $color }}" stroke="none" cx="6" cy="50" r="6">
                <animateTransform attributeName="transform" dur="1s" type="translate" values="0 15 ; 0 -15; 0 15" repeatCount="indefinite" begin="0.1"/>
            </circle>
            <circle fill="{{ $color }}" stroke="none" cx="30" cy="50" r="6">
                <animateTransform attributeName="transform" dur="1s" type="translate" values="0 10 ; 0 -10; 0 10" repeatCount="indefinite" begin="0.2"/>
            </circle>
            <circle fill="{{ $color }}" stroke="none" cx="54" cy="50" r="6">
                <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3"/>
            </circle>
        </svg>
        @break
    @case('bars')
        <!-- Bars -->
        <svg style="vertical-align: middle;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
            <rect fill="{{ $color }}" width="3" height="100" transform="translate(0) rotate(180 3 50)">
                <animate attributeName="height" attributeType="XML" dur="1s" values="30; 100; 30" repeatCount="indefinite"/>
            </rect>
            <rect x="17" fill="{{ $color }}" width="3" height="100" transform="translate(0) rotate(180 20 50)">
                <animate attributeName="height" attributeType="XML" dur="1s" values="30; 100; 30" repeatCount="indefinite" begin="0.1s"/>
            </rect>
            <rect x="40" fill="{{ $color }}" width="3" height="100" transform="translate(0) rotate(180 40 50)">
                <animate attributeName="height" attributeType="XML" dur="1s" values="30; 100; 30" repeatCount="indefinite" begin="0.3s"/>
            </rect>
            <rect x="60" fill="{{ $color }}" width="3" height="100" transform="translate(0) rotate(180 58 50)">
                <animate attributeName="height" attributeType="XML" dur="1s" values="30; 100; 30" repeatCount="indefinite" begin="0.5s"/>
            </rect>
            <rect x="80" fill="{{ $color }}" width="3" height="100" transform="translate(0) rotate(180 76 50)">
                <animate attributeName="height" attributeType="XML" dur="1s" values="30; 100; 30" repeatCount="indefinite" begin="0.1s"/>
            </rect>
        </svg>
        @break
    @case('square')
    @default   
        <!-- square -->
        <svg style="vertical-align: middle;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
            <rect fill="none" stroke="{{ $color }}" stroke-width="4" x="25" y="25" width="50" height="50">
                <animateTransform attributeName="transform" dur="0.5s" from="0 50 50" to="180 50 50" type="rotate" id="strokeBox" attributeType="XML" begin="rectBox.end"/>
            </rect>
            <rect x="27" y="27" fill="{{ $color }}" width="46" height="50">
                <animate attributeName="height" dur="1.3s" attributeType="XML" from="50"  to="0" id="rectBox"  fill="freeze" begin="0s;strokeBox.end"/>
            </rect>
        </svg>
@endswitch

    @if ($text)    
        <p style="margin: 0; top: 50%; transform: translate(0, -50%); position: absolute;">{{ $text }}</p>        
    @endif
</div>