<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <link rel="shortcut icon" href="{{ asset('vendor/adminto/images/favicon.ico') }}">
        <title>{{ $section ?? 'Login '.config('app.name') }}</title>        
        <!-- Toastr --> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <!-- App css -->
        <link href="{{ asset('vendor/adminto/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/adminto/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/adminto/css/style.css') }}" rel="stylesheet" type="text/css" />

        <script src="{{ asset('vendor/adminto/js/modernizr.min.js') }}"></script>

        @livewireStyles
        @stack('styles')
        @stack('scripts.head')
    </head>

    <body>

        <div>
            <x-alert flash="success" class="success" />
            <x-alert flash="error" class="danger" />
        </div>

        @yield('content')

        {{ $slot ?? ''}}

        <x-modal id="modal-files-manager-preview-file-id" data-backdrop="static">                           
            @livewire('files-manager-view-file',[
                'modalId' => '#modal-files-manager-preview-file-id'
            ])
        </x-modal>

        <!-- jQuery  -->
        <script src="{{ asset('vendor/adminto/js/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/popper.min.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/detect.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/fastclick.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/waves.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.scrollTo.min.js') }}"></script>
        <!-- SweetAlert -->
        <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.9/dist/sweetalert2.all.min.js"></script>
        <!-- Axios -->
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <!-- Toastr -->
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- App js -->
        <script src="{{ asset('vendor/adminto/js/jquery.core.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.app.js') }}"></script>        
        
        <!-- Develper global scripts -->
        <script defer src="{{ asset('vendor/laravel-starter/js/global.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/sweet-alert2.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/toastr-config.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/modals.js') }}"></script>
	
        @livewireScripts
        @stack('scripts')
	</body>
</html>