<div class="p-3">
    <h4 class="text-center header-title"> {{ $fileTitle ?? 'Previsualizar archivo' }}</h4>
    @if ($isExternal)
      <code>Archivo externo: {{ $fileAsset }}</code>
    @else
      <code>:~ dir$ {{ $fakePath }}</code>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="p-20 text-center" style="padding-bottom: 0px">

            
            @if ($invalidFile || !in_array($mode, ['SIMPLE-FILE', 'GET-CONTENTS']))
                <img src="{{ $fileAsset }}">
                <div class="iframe-responsive">
                    <small>Intentando procesar como imagen ya que no se encontro una extensión de archivo válido (puede no funcionar).</small>
                    <div>Archivo no soportado o no existe</div>
                </div>
            @elseif ($mode == 'SIMPLE-FILE')
                @if (Str::contains($fileType,['image','gift']) )
                    <img src="{{ $fileAsset }}" class="img-fluid" alt="">
                @elseif (Str::contains($fileType,'video'))
                    <video src="{{ $fileAsset }}" controls width="640" height="480" class="img-fluid">Lo sentimos. Este vídeo no puede ser reproducido en tu navegador.</video>
                @elseif($fileType == 'youtube')
                    <div class="iframe-responsive">
                        <iframe src="https://www.youtube.com/embed/{{ get_youtube_video_id($fileAsset) }}"
                                frameborder="0"
                                title="youtube"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <img src="{{ $fileAsset }}">
                    <div class="iframe-responsive">
                        <small>Intentando procesar como imagen ya que no se encontro una extensión de archivo válido (puede no funcionar).</small>
                        <div>Archivo no soportado o no existe</div>
                    </div>
                @endif              
            @elseif ($mode == 'GET-CONTENTS')
                <div class="iframe-responsive">
                    <iframe src="{{ $fileAsset }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif

            <div class="text-center">
                <button type="button"
                        class="mt-3 btn btn-secondary"
                        data-dismiss="modal"
                        aria-label="Close"
                        wire:click.prevent="resetInputFields()"
                        >
                    Cancelar / Cerrar
                </button>
            </div>

            </div>
        </div>
    </div>
</div>
