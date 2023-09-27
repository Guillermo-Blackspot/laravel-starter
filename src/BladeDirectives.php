<?php
namespace BlackSpot\Starter;

use Illuminate\Support\Arr;
use ArrayAccess;

class BladeDirectives
{
    public static function jsUrlScript()
    {
        return "
            <script>
                function url(__URL__, __QUERY__){
                    let globalUrl = <?php echo json_encode(url('/')); ?>;
                    let params    = (__QUERY__) 
                                        ? '?' + (new URLSearchParams(__QUERY__)).toString()
                                        : '';
                    return globalUrl + __URL__ + params;
                }
            </script>
        ";
    }


    public static function dispatchBrowserEventsScript()
    {
        return "
            <?php if (isset(\$browserEventDetail) || session()->has('browserEventDetail')): ?>        
                <script>
                    window.addEventListener('DOMContentLoaded', function(){
                        var browserEventDetail = <?php echo json_encode(session()->get('browserEventDetail', (isset(\$browserEventDetail) ? \$browserEventDetail : []))); ?>;
                        const controllerEvent = new CustomEvent(browserEventDetail.event, { detail: browserEventDetail.arguments });
                        // Dispatch the event.
                        window.dispatchEvent(controllerEvent);          
                    });
                </script>
            <?php endif; ?>
        ";
    }

    public static function starterScripts()
    {
        return $this->jsUrlScript() . $this->dispatchBrowserEventsScript();
    }

}