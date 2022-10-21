window.addEventListener('DOMContentLoaded', function(){    
    if (window.jQuery) {
        if (jQuery().modal) {            
            window.addEventListener('browser_event.bootstrap.modal-open', ({detail}) => {        
                $(detail.modalId).modal('show');
            });

            window.addEventListener('browser_event.bootstrap.modal-close', ({detail}) => {
                $(detail.modalId).modal('hide');
            });    
        }
    }
});