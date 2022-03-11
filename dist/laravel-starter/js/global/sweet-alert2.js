
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


swal.info = function(text, enableAll = false){

  let res = resolveTextOrHtml(text);

  return this({
    type: 'info',
    title: 'Info',
    [res.key]: res.text || '',
    allowOutsideClick: enableAll,
    allowEscapeKey: enableAll,
    allowEnterKey: enableAll,
    showCancelButton: false,
    showConfirmButton: enableAll
  });
}

swal.loading = function(text){
  return this({
    type: 'info',
    title: 'Info',
    text: text || 'Cargando información ...',
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCancelButton: false,
    showConfirmButton: false
  });
}

swal.noCancelable = function(type,title,text){
  return this({
    type: type,
    title: title,
    text: text,
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCancelButton: false,
    showConfirmButton: false
  });
}

swal.error = function(title,text){
  return this({
    type: 'error',
    title: title,
    text: text,
    confirmButtonClass: 'btn btn-success w-button -btn-red',
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCancelButton: false,
  })
}


swal.success = function(title, text){
  return this({
    type: 'success',
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
    type: icon || 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, Continuar',
    cancelButtonText: 'No, cancelar',
    confirmButtonClass: 'w-button w-button-green w-mx-15 btn btn-success mr-1',
    cancelButtonClass: 'w-button w-button-red w-mx-15 btn btn-danger',
    buttonsStyling: false
  });
};

window.addEventListener(SWEET_ALERT_BROWSER_EVENT+'.close', event => swal.close());
window.addEventListener(SWEET_ALERT_BROWSER_EVENT+'.open', ({detail}) => {
  swal(detail.body)
  .then(
    (result)=> result,
    (dismiss)=> dismiss
  )
  .then((result)=>{
    let validResult = (detail.with)
                    ? [result, detail.with]
                    : [result];

    if (detail.emit) {
      Livewire.emit(emit, ...validResult);
    }
    if (detail.emitTo) {
      Livewire.emitTo(detail.emitTo[0], detail.emitTo[1], ...validResult);
    }
    if (detail.emitSelf) {
      Livewire.emitSelf(detail.emitSelf, ...validResult);
    }
    if (detail.emitParent) {
      Livewire.emitParent(detail.emitParent, ...validResult);
    }
    if (Object.keys(detail).join(', ').includes('emit') && result !== 'cancel') {
      if (toastr) toastr.info('Espere..');
    }
  })
  .catch(swal.noop)
});