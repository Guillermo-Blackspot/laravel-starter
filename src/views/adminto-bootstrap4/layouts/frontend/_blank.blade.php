<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="{{ asset('vendor/adminto/images/favicon.ico') }}">

        <title>{{ $section ?? 'Login - '.config('app.name') }}</title>

        <!-- SweetAlert -->
        <link href="{{ asset('vendor/sweet-alert/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Toastr -->
        <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        
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

        <div class="row">
            <x-alert session="true:success" type="success" dismiss="true" class="col-12" />
            <x-alert session="true:error" type="danger" dismiss="true" class="col-12" />
        </div>

        @yield('content')

        {{ $slot ?? ''}}

        <x-simple-modal id="modal-files-manager-preview-file-id" data-backdrop="static">                           
            @livewire('files-manager-view-file',[
                'modalId' => '#modal-files-manager-preview-file-id'
            ])
        </x-simple-modal>

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
        <script defer src="{{ asset('vendor/sweet-alert/sweetalert2.min.js') }}"></script>
        <!-- Toastr -->
        <script defer src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
        
        <!-- App js -->
        <script src="{{ asset('vendor/adminto/js/jquery.core.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.app.js') }}"></script>

        <!-- Axios -->
        <script defer src="{{ asset('vendor/axios/axios.min.js') }}"></script>        
        <!-- Develper global scripts -->
        <script defer src="{{ asset('vendor/laravel-starter/js/global/global.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/global/sweet-alert2.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/global/toastr-config.js') }}"></script>
	
        @livewireScripts
        @stack('scripts')
	</body>
</html>