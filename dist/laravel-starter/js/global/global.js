function debounceLeading(func, timeout = 300) {
    let timer;
    return (...args) => {
      if (!timer) {
        func.apply(this, args);
      }
      clearTimeout(timer);
      timer = setTimeout(() => {
        timer = undefined;
      }, timeout);
    };
}
  

/**
 * ------------------------------------------------------ 
 * When document was loaded
 * ------------------------------------------------------ 
 */

/**
 * When the dom is ready call the callback
 * 
 * @param {function} fn 
 */

function domReady(fn) {
    // see if DOM is already available
    if (window.document.readyState === "complete" || window.document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        window.document.addEventListener("DOMContentLoaded", fn);
    }
}


/**
 * ------------------------------------------------------ 
 * Object facades
 * ------------------------------------------------------ 
 */


/**
 * String helpers
 * 
 * @var {const}
 */
var Str = {    

    /**
     * Generate random string 
     * @param {Integer} length
     * @returns String
     */

    random : function(length) {
        let result           = '';
        let characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
};

 


/**
 * ------------------------------------------------------ 
 * Form helpers
 * ------------------------------------------------------ 
 */


/**
 * Set the fa-eye icon in all password inputs
 * for show/hide the password
 * 
 * @return {void}
 */
function setHideShowPasswordIconOnInputs() {

    document.querySelectorAll('input[type=password]')
            .forEach((input)=>{
                let fnId = Str.random(20).replace(/^([0-9]+)/g, '');
                input.setAttribute('data-fn-id',fnId);
                input.insertAdjacentHTML('afterend', `
                    <span 
                        style="                    
                        margin-bottom: 20px;
                        right: 10px;
                        top: 5px;
                        z-index: 1;
                        cursor: pointer;
                        position: absolute;
                        "
                        onclick="javascript:document.querySelector('input[data-fn-id=${fnId}]').type == 'password' ? document.querySelector('input[data-fn-id=${fnId}]').type = 'text' : document.querySelector('input[data-fn-id=${fnId}]').type = 'password' ">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                `);
                input.parentNode.style.position = 'relative';
            });
}




/**
 * -------------------------------
 * Miscellaneous
 * -------------------------------
 */

/**
 * Debug
 */
function debug() {
    console.log(...arguments);    
}

/**
 * Filter options from an un order list (ul)
 * 
 */
function filterPresentOptionsFromUlParser(input) {
    let search        = input.value.toLowerCase().trim();
    let mainComponent = input.closest('.select-multiple');
    let containerList = mainComponent.getElementsByTagName("ul")[0];
    let listItems     = containerList.getElementsByTagName('li');
    let searchButton  = mainComponent.querySelector('.btn-search-if-not-exists');

    return {
        search: search,
        mainComponent: mainComponent,
        containerList: containerList,
        listItems: listItems,
        searchButton: searchButton
    }; 
}
/**
 * Hide or show the options
 * @param {Element} input 
 * @param {Boolean} forceToHide 
 */
function filterUlOptionsHideToggle(input) {
    const {containerList, listItems} = filterPresentOptionsFromUlParser(input);

    if (!input.dataset.filterUlToggle || input.dataset.filterUlToggle == 'closed') {        
        input.dataset.filterUlToggle = 'opened';
        containerList.style.position = containerList.dataset['position'] || 'absolute';
        containerList.style.zIndex   = 9999999999999;
        containerList.classList.add('shadow');
    }else if (input.dataset.filterUlToggle == 'opened') {
        input.dataset.filterUlToggle = 'closed';
        containerList.style.position = '';
        containerList.style.zIndex   = '';
        containerList.classList.remove('shadow');
    }
    
    for (let i = 0; i < listItems.length; i++) {
        if(input.dataset.filterUlToggle == 'closed' || !input.dataset.filterUlToggle) {
            if (listItems[i].classList.contains('selected')) {
                listItems[i].style.display = '';    
            }else{
                listItems[i].style.display = 'none';
            }            
        }else if (input.dataset.filterUlToggle == 'opened'){
            listItems[i].style.display = '';
        }
    }        
}
/**
 * Start the filtering
 * @param {Element} input 
 */
function filterUlOptionsStartFiltering(input) {
    const {search, searchButton, listItems} = filterPresentOptionsFromUlParser(input);
    let count = 0;

    for (let index = 0; index < listItems.length; index++) {
        const li = listItems[index];
        
        if(search == null || search == ''){    
            li.style.display = '';
            count++;
            continue;
        }
        
        if (li.classList.contains('helper')) {
            li.style.display = '';
            continue;
        }

        li.style.display = 'none';

        if (li.dataset.optionLabel && li.dataset.optionLabel.trim().toLowerCase().includes(search)) {
            li.style.display = '';
            count++;
        } 
    }

    if(searchButton){
        if (!count) {
            searchButton.style.display = '';
        }else{
            searchButton.style.display = 'none';
        }
    }

}




function attachModalsToggle() {    
    document.querySelectorAll('[data-fn-modal-settings]')
            .forEach((target)=>{                            
                
                
                
                if (target.classList.contains('modal-processed')) {
                    return 0;
                }
                
                //let raw = target.dataset.fnModalSettings;
                //let settings = {};
                let settings = JSON.parse(target.dataset.fnModalSettings);
                
                /*raw.split(",").forEach(i => {                                    
                    let sp = i.split(':').map( i => i.trim());
                    settings[sp[0]] = sp[1];
                });
                */
                
                if (!settings.attach) {
                    if(!target.id){
                        target.setAttribute('id', Str.random(17));
                    }else if(!target.dataset.fnTooltipIsReferenceOfAnother){
                        settings.attach = '#'+target.id;                            
                    }else{
                        throw "modal settings require an attach id target";
                    }
                }
                settings.content = $(settings.content);   
                settings.onClose = ()=>{
                    window.Livewire.emit(settings._onCloseLivewireEmitTo[1]);
                };


            
                let __new = new jBox('Modal', settings);                
                target.classList.add('modal-processed')
            });

       
}


/**
 * Keyboard functions
 */

function copy(text, domElementId) {
    Ctrl_C(text, domElementId);
}

function Ctrl_C(text, domElementId){
    let aux = document.createElement("input");
    
    if (domElementId) {
        
        /**
        * as element
        */
        aux.setAttribute("value", document.getElementById(domElementId).innerHTML);
    }else{
        /**
        * As text
        */
        aux.setAttribute("value", text || '');
    }

    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);

    toastr.success('¡Copiado!');
}


/**
 * Fadeout alerts
 */

function fadeOutAlerts() {
    document.querySelectorAll('.alert.alert-dismissible')
            .forEach((el)=>{
                el.style.transition = 'all 0.5s ease-out';
                fadeOut(el, 1700);
            });
}


/**
 * -----------------------------
 * Animations
 * -----------------------------
 */

/**
 * Fade out an dom element
 * 
 * @param {Element} target 
 * @param {Boolean,Integer} delay 
 */
function fadeOut(target, delay) {

    let fadeEffect = null;
    let intervalFn = function () {
        if (!target.style.opacity) {
            target.style.opacity = 1;
            target.style.display = 'block';
        }
        if (target.style.opacity > 0) {
            target.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
            target.style.display = 'none';
        }
    };

    if (delay) {
        setTimeout(()=> fadeEffect = setInterval(intervalFn, 200), typeof delay === 'boolean' ? 1200 : delay);
    }else{
        fadeEffect = setInterval(intervalFn, 200);
    }
}


/**
 * Init the jBox tooltips or fresh them
 */
function initToolTips() {    
    document.querySelectorAll("[data-fn-tooltip-id]")
            .forEach((target)=>{

                if (target.classList.contains('tooltip-processed')) {
                    return 0;
                }

                if (!target.dataset.fnTooltipIsReferenceOfAnother && !target.id ) {
                    target.setAttribute('id', target.dataset.fnTooltipId);
                }

                new jBox('Tooltip', {
                    attach: '#'+target.dataset.fnTooltipId,
                    theme: 'TooltipDark'
                });

                target.classList.add('tooltip-processed');

            });
}


function fixBootstrapTableBugWithDropdownButtonOptions() {
//     $('.table-responsive').on('show.bs.dropdown', function () {
//         $('.table-responsive').css( "overflow", "inherit" );
//    });
   
//    $('.table-responsive').on('hide.bs.dropdown', function () {
//         $('.table-responsive').css( "overflow", "auto" );
//    })
}

/**
 * Modals
 */
 var currentModalId = '';

function simpleModal(modalId, action){
    let modal = document.querySelector(modalId);
    if (action == 'show') {
        currentModalId = modalId;
        modal.style.display = "block";
    }else{
        currentModalId = null
        modal.style.display = "none";
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {   
    
    if (currentModalId) {

        if (event.target.id == currentModalId.replace('#','')) {
            if (event.target.dataset['backdrop'] != 'static') {                
                simpleModal(currentModalId,'hide');
            }
        }else if(event.target.classList.contains('simple-close')){
            simpleModal(currentModalId,'hide');
        }
    }
    
}

//End modals

function globalLoadingState(visibility) {
    //let globalLoading = document.querySelector('#global-loading-state-id');
    if (globalLoading) {
        if (visibility == 'show') {
            globalLoading.style.display = 'inline-block';
        }else{            
            globalLoading.style.display = 'none';
        }
    }
}

var globalLoading = null;

domReady(function () {
    setHideShowPasswordIconOnInputs();
    fadeOutAlerts();
    initToolTips();
    attachModalsToggle();
    fixBootstrapTableBugWithDropdownButtonOptions();

    if (window.Livewire) {        
        window.Livewire.hook('message.sent', (fromEl, toEl, component) => {            
            globalLoadingState('show');
        });
        window.Livewire.hook('message.processed', (message, component) => {
            setHideShowPasswordIconOnInputs();
            fadeOutAlerts();
            initToolTips();
            attachModalsToggle();
            if(Object.keys(message.response.serverMemo.errors).length && window.toastr){
                toastr.error('Algunos datos no cumplieron la validación.');
            }
            globalLoadingState('hide');
        });
        window.Livewire.hook('message.failed', (message, component) => {
            swal.close();
        });
    }

    window.addEventListener('bootstrap.modal-open', ({detail}) => {
        $(detail.modalId).modal('show');
    });
    window.addEventListener('bootstrap.modal-close', ({detail}) => {
        $(detail.modalId).modal('hide');
    });


    globalLoading = document.querySelector('#global-loading-state-id');
});