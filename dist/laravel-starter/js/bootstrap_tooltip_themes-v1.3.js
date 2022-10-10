
function renderTooltips() {
    let doms = $('[data-toggle="tooltip"]');
        doms.on('inserted.bs.tooltip', function (evt) {
            let tooltip = document.querySelector('#'+evt.target.getAttribute('aria-describedby'));
            if (evt.target.dataset['tooltipTheme']) {                            
                tooltip.classList.add('tooltip-'+evt.target.dataset['tooltipTheme']);
            }            
            if (evt.target.dataset['tooltipWidth']) {                            
                tooltip.style['maxWidth'] = 'none';
                tooltip.childNodes[1].style['maxWidth'] = evt.target.dataset['tooltipWidth']
            }
        })
        doms.tooltip();
}

document.addEventListener("DOMContentLoaded", () => {
    renderTooltips();            
    if (window.Livewire) {        
        Livewire.hook('message.processed', (message, component) => {
            renderTooltips();     
        })
    }
});