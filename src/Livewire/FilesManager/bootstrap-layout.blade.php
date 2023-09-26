<div class="p-3">
    <h4 class="text-center header-title"> {{ $title ?? 'Previsualización de archivo' }}</h4>
    <code>{{ $fileUrl }}</code>

    <div class="row">
        <div class="col-12">
            <div class="p-20 text-center" style="padding-bottom: 0px">

            @if ($this->fileType === false)
                <img src="{{ $fileUrl }}" class="img-fluid">
                <div class="iframe-responsive">
                    <small>Intentando procesar como imagen ya que no se encontro una extensión de archivo válido (puede no funcionar).</small>
                    <div>Archivo no soportado o no existe</div>
                </div>
            @elseif ($mode == self::SIMPLE_FILE_TYPE)
                @if ($fileType == 'image')
                    <img src="{{ $fileUrl }}" class="img-fluid" alt="">
                @elseif ($fileType == 'video')
                    <video src="{{ $fileUrl }}" controls width="640" height="480" class="img-fluid">Lo sentimos. Este vídeo no puede ser reproducido en tu navegador.</video>
                @elseif($fileType == 'youtube')
                    <div class="iframe-responsive">
                        <iframe src="https://www.youtube.com/embed/{{ get_youtube_video_id($fileUrl) }}"
                                frameborder="0"
                                title="youtube"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <img src="{{ $fileUrl }}" class="img-fluid">
                    <div class="iframe-responsive">
                        <small>Intentando procesar como imagen ya que no se encontro una extensión de archivo válido (puede no funcionar).</small>
                        <div>Archivo no soportado o no existe</div>
                    </div>
                @endif              
            @elseif ($mode == self::GET_CONTENTS_TYPE)
                <div class="iframe-responsive">
                    <iframe src="{{ $fileUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif

            @if ($description)
                <p style="mt-4 mb-0 text-secondary w-100 text-left bg-muted p-2">{{ $description }}</p>
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
