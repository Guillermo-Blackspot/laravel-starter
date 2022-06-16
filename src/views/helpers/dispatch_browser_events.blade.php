@if (isset($browserEventDetail) || session()->has('browserEventDetail'))      
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            var browserEventDetail = @json(session()->get('browserEventDetail', (isset($browserEventDetail) ? $browserEventDetail : []) ));
            const controllerEvent = new CustomEvent(browserEventDetail.event, { detail: browserEventDetail.arguments });
            // Dispatch the event.
            window.dispatchEvent(controllerEvent);          
        });
    </script>
@endif