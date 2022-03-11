/**
 * Toast configuration
 */
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-bottom-left",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


/**
 * Responding to window events
 */

const TOASTR_BROWSER_EVENT = 'browser_event.toastr';

/**
 * Dispatch toastr component
 *
 * @param array component
 * {
 *   type:  'success',
 *   title:  'Ok' ,
 *   desc:    'desc' ,
 *   override: [] //ooptional
 * }
 */
toastr.dispatchComponent = function(component){
    if (typeof component === 'object' && Object.keys(component).length) {
      let args = [];

      /**
       * Associative
       */
      if (component.title) {
        args.push(component.title);
      }
      if (component.desc) {
        args.push(component.desc);
      }
      if (component.override ) {
        if (component.desc == undefined || component.desc == null) {
          args.push(null);
        }
        args.push(component.override);
      }

      /**
       * Positionally
       */
       if (Array.isArray(component)) {
           component.type = component[0];
           
           if (component[1]) {
             args.push(component[1]);
           }
           if (component[2]) {
             args.push(component[2]);
           }
           if (component[3]) {
              if (component[2] == undefined || component[2] == null) {
                args.push(null);
              }
             args.push(component[3]);
           }
       }
       if (args) {
         this[component.type](...args);
       }

    }
};

/**
 * Override toastr options
 */
toastr.overrideOptions = function(newOptions) {
    if (typeof newOptions === 'object' && Object.keys(newOptions).length) {
      Object.keys(newOptions).forEach(key => this.options[key] = newOptions[key]);
    }
};

/**
 * Toastr events
 */
window.addEventListener(TOASTR_BROWSER_EVENT, ({detail}) => {    
    toastr.dispatchComponent(detail.component)
    //toastr.overrideOptions(detail.override);
});


/**
 * Backrground and Target accessing
 */

function wrapToast(toasrtResult) {
  return toasrtResult[0];
}
