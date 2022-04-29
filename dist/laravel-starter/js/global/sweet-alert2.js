
/**
 * Responding to window events
 */

const SWEET_ALERT_BROWSER_EVENT = 'browser_event.sweetalert2';


function resolveTextOrHtml(text) {
  textOrHTML = 'text';

  if(text.includes('<_HTML_>') && text.includes('</_HTML_>')){
    textOrHTML = 'html';
    text = text.trim().replace('<_HTML_>','').replace('</_HTML_>','');
  }

  return {
    key: textOrHTML, 
    text: text
  };
}


Swal.info = function(text, enableAll = false){
  let res = resolveTextOrHtml(text);

  return this({
    icon: 'info',
    title: 'Info',
    [res.key]: res.text || '',
    allowOutsideClick: enableAll,
    allowEscapeKey: enableAll,
    allowEnterKey: enableAll,
    showCancelButton: false,
    showConfirmButton: enableAll
  });
}
 
Swal.loading = function(text){
  return this({
    icon: 'info',
    title: 'Info',
    text: text || 'Cargando información ...',
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCancelButton: false,
    showConfirmButton: false
  });
}

Swal.noCancelable = function(icon,title,text){
  return this({
    icon: icon,
    title: title,
    text: text,
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCancelButton: false,
    showConfirmButton: false
  });
}

Swal.error = function(title,text){
  return this({
    icon: 'error',
    title: title,
    text: text,
    confirmButtonClass: 'btn btn-success w-button -btn-red',
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCancelButton: false,
  })
}
 
 
Swal.success = function(title, text){
  return this({
    icon: 'success',
    title: title,
    text: text,
    confirmButtonColor: '#4fa7f3',
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCancelButton: false,
  });
}
 
swal.confirm = function(title, text, icon){   
  let res = resolveTextOrHtml(text);

  return this({
    title: title || '¿Deseas continuar?',
    [res.key]: res.text || '',
    icon: icon || 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, Continuar',
    cancelButtonText: 'No, cancelar',
    confirmButtonClass: 'w-button w-button-green w-mx-15 btn btn-success mr-1',
    cancelButtonClass: 'w-button w-button-red w-mx-15 btn btn-danger',
    buttonsStyling: false
  });
};
 
 
function miDisenio(detail) {
  return Swal.fire({
     title: 'Are you sure?',
     text: "You won't be able to revert this!",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes, delete it!'
   }).then((result) => {
     if (result.isConfirmed) {
       Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
       );
     }
     return result;
  });
}

window.addEventListener(SWEET_ALERT_BROWSER_EVENT+'.close', event => swal.close());
window.addEventListener(SWEET_ALERT_BROWSER_EVENT+'.open', ({detail}) => {
  const resolveSwal = function(_detail){  
    if (_detail.body) {
      return Swal.fire(_detail.body);
    }else if(_detail.callingDesign){
      return window[_detail.callingDesign](_detail);
    }else{
      throw "No body or caller found!";
    }
  };

  resolveSwal(detail).then((result)=>{
    
    if (!detail.emitOnFail) {
      if (!result) return 0;      
    }

    // isConfirmed: true
    // isDenied: false
    // isDismissed: false
    // value: true

    let validResult = (detail.with) ? [result, detail.with] : [result];
    if (detail.emits) {
      if (Array.isArray(detail.emits)) {
        detail.emits.forEach(concreteEmit => {
          let fnEmit = Object.keys(concreteEmit)[0];
          Livewire[fnEmit](...concreteEmit[fnEmit],  ...validResult);
        });
      }else if (typeof detail.emits === 'object') {
        Object.keys(detail.emits).forEach(concreteEmit => {
          Livewire[concreteEmit](...detail.emits[concreteEmit],  ...validResult);
        });
      }
    }        
    if (detail.emits) {
      if (toastr) toastr.info('Espere..');
    }
  })
  .catch(({message}) => console.log(message))
});