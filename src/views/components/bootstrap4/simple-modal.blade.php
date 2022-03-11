<div class="modal fade"
     id="{{ $id }}"
     wire:ignore.self
     tabindex="-1"
     role="dialog"
     aria-labelledby="{{ $id.'--labelledby' }}"
     aria-hidden="true"
     {{ $attributes }}>
  <div class="modal-dialog {!! $size ?? '' !!}" role="document">
    <div class="modal-content p-0" style="background-color: {{ $bgColor }}">
      @if ($title != null)
        <div class="modal-header">
          <h5 class="modal-title" id="{{ $id.'--labelledby' }}">{{ $title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <div class="modal-body p-1">
        {{ $slot ?? '' }}
      </div>
    </div>
  </div>
</div>
