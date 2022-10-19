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
 * Debug
 */
function debug() {
    console.debug(...arguments);    
}
function dd() {
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

/**
 * Keyboard functions
 */

function copy(text, domElementId) {
    Ctrl_C(text, domElementId);
}

function Ctrl_C(text, domElementId){
    let aux = document.createElement("input");
    
    if (domElementId) {        
        // As element
        aux.setAttribute("value", document.getElementById(domElementId).innerHTML);
    }else{
        // As text
        aux.setAttribute("value", text || '');
    }
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
    displayToastSuccess('¡Copiado!');
}


/**
 * Fadeout alerts
 */

function fadeOutAlerts() {
    document.querySelectorAll('.alert.alert-auto-fadeout')
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

function displayToastError(message) {
    if (window.toastr) {        
        toastr.error(message);
    }
}
function displayToastSuccess(message) {
    if (window.toastr) {        
        toastr.success(message);
    }
}

function hideSweetAlert() {
    if (window.Swal) {
        Swal.close();    
    }
    if (window.swal) {
        swal.close();
    }
}

function setTopMenuLoaderAs(visibility) {
    //let globalLoading = document.querySelector('#global-loading-state-id');
    if (globalLoading) {
        if (visibility == 'show') {
            globalLoading.style.display = 'inline-block';
        }else{            
            globalLoading.style.display = 'none';
        }
    }
}


function settingUpJQueryFunctions() {
    if (window.jQuery) {
        if (jQuery().tooltip) {
            $('[data-toggle="tooltip"]').tooltip()
        }
    }
}

function settingUpLaraveLivewireFunctions() {
    if (window.Livewire) {    
        window.Livewire.hook('message.sent', (fromEl, toEl, component) => {            
            setTopMenuLoaderAs('show');
        }); 

        window.Livewire.hook('message.processed', (message, component) => {
            
            fadeOutAlerts();
            
            if(Object.keys(message.response.serverMemo.errors).length){
                displayToastError('Algunos datos no cumplieron la validación.');
                console.log(message.response.serverMemo.errors);
            }

            setTopMenuLoaderAs('hide');
        });

        window.Livewire.hook('message.failed', (message, component) => {
            hideSweetAlert();
        });
    }
}

var globalLoading = null;

domReady(function () {
    globalLoading = document.querySelector('#global-loading-state-id');
    
    fadeOutAlerts();    
    settingUpJQueryFunctions();
    settingUpLaraveLivewireFunctions();

    window.addEventListener('bootstrap.modal-open', ({detail}) => {
        $(detail.modalId).modal('show');
    });
    window.addEventListener('bootstrap.modal-close', ({detail}) => {
        $(detail.modalId).modal('hide');
    });    
});