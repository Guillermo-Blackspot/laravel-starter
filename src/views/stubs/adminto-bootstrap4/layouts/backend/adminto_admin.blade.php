<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="description">
        <meta name="author" content="Coderthemes">
        <title>{{ $section ?? 'Admin - '.config('app.name', 'Tu empresa') }}</title>        
        <!-- Icon -->
        <link rel="shortcut icon" href="{{ asset('vendor/adminto/images/favicon.ico') }}">        
        <!-- App css -->
        <link href="{{ asset('vendor/adminto/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/adminto/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/adminto/css/style.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ asset('vendor/adminto/js/modernizr.min.js') }}"></script>

        <!-- Develper global styles -->
        <link rel="stylesheet" href="{{ asset('vendor/laravel-starter/css/global.css') }}" type="text/css">
        {{-- Bootstrap tooltip themes --}}
        <link rel="stylesheet" href="{{ asset('vendor/laravel-starter/css/bootstrap_tooltip_themes.css') }}">
        <!-- Toastr -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" type="text/css" />
        {{-- Select2 --}}
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

        @livewireStyles            
        <style>
            /* Buttons */
            .btn-white{
                background-color: #fff;
                border: 1px solid #efefef;
                color: #525252;
            }
            /* Miscellaneous */
            .h-100px{ height: 100px; }
            .h-200px{ height: 200px; }
            .h-300px{ height: 300px; }
            .w-300px{ width: 300px; }
            .w-200px{ width: 200px; }
            .w-100px{ width: 100px; }

            .nav-tabs .nav-link.active{
                border-color: #ebeff2 !important;
                background-color: #ebeff2 !important;
            }
            .px-20{
                padding-right: 20px;
                padding-left: 20px;
            }
            .py-20{
                padding-top: 20px;
                padding-bottom: 20px;
            }
            .ck-editor__editable {
                min-height: 300px;
            }
            .swal2-close:focus{
                box-shadow: none !important;
            }
            .border-bottom-grey{
                border-bottom: 1px solid #efefef;
            }

            .border-left-grey{
                border-left: 1px solid #efefef;
            }

            .border-right-grey{
                border-right: 1px solid #efefef;
            }
            table.table th{
                vertical-align: middle;
            }
            .custom-file-upload{
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
            }
            textarea.form-control{
                min-height: 50px;
            }
            .modal-body{
                padding: 0px !important;
            }
            .simple-filter-colors{
                background-color: rgb(91 105 188) !important;
                color: #fff !important;
            }

            input[type=submit],
            .simple-filter-colors,
            .btn {
                border-radius: 4px;
                /*box-shadow: 0 0px 24px 0 rgb(0 0 0 / 6%), 0 1px 0px 0 rgb(0 0 0 / 2%);*/
                /*box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;*/
                /*box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;*/
            }
            .badge{
                border-radius: 5px;
                padding: 5px;
                font-size: 12px;
                /*letter-spacing: 1px;*/
                box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
                color: inherit;
            }
            .badge-primary,
            .badge-danger,
            .badge-secondary,
            .bade-purple,
            .badge-success{ color: #fff; }

            .badge-paused { background-color: #dca847; color: #fff; }
            .badge-incomplete { background-color: #ce8a08; color: #fff; }
            .badge-incomplete_expired { background-color: #b41217; color: #fff; }
            .badge-trialing{ background-color: #1b54d9; color: #fff; }
            .badge-a, .badge-active, .active_no_invoices { background-color: #257a0e; color: #fff; }
            .badge-past_due, .badge-c, .badge-canceled, .badge-unlinked, .badge-restricted { background-color: #b41217; color: #fff; }
            .badge-unpaid { background-color: #9ea9b4; color: #fff; }

            .card-box{ border-radius: 10px; }

            .modal-content{ border-radius: 10px !important; }
            .page-item > .page-link{
                color: #495057;
                font-weight: 600;
            }

            /* Page item  */
            .page-item > .page-link.disabled{ background-color: #fff; }
            .page-item > .page-link.active{ background-color: #e9ecef; }

            /* SweetAlert2 */            
            .swal2-actions.swal2-confirm:focus,
            .swal2-actions.swal2-deny:focus,
            .swal2-actions.swal2-cancel:focus { box-shadow: none !important; }
            .--swal2-actions { gap: 20px; }

            /* text */
            .fs-12 { font-size: 12px; }
            .fs-14 { font-size: 14px; }
            .fs-16 { font-size: 16px; }
            .fs-18 { font-size: 18px; }
            .fs-20 { font-size: 20px; }

            /* flex */
            .gap-5{ gap: 5px; }
        </style>

        <style>
            /* .btn {
                background-color: #f6f7f9;
            } */
            #quick-access-options {
                color: #000836;
            }

            .navbar-default, 
            .content{
                padding: 0 20px !important;
            }
            /*--util .button-menu-mobile{
                color: #fff;
            }             */
            .topbar .topbar-left, 
            .navbar-default {
                border-top: none !important;
            }

            #sidebar-menu > ul > li,
            #sidebar-menu > ul > li > a {
                background-color: transparent;
            }     
            .nav-item.dropdown a{
                font-size: 22px !important;
            }
            .nav-item.dropdown a.dropdown-item{
                line-height: normal !important;
                font-size: 14px !important;
            }          
            @media (max-width: 768px){
                .topbar-left {
                    display: none;
                }
                .topbar .topbar-left {
                    height: 71px;
                }
                .navbar-default {
                    background-color: #13174a;
                    color: #a9b1b4;
                    box-shadow: 0 0px 24px 0 rgb(0 0 0 / 6%), 0 1px 0px 0 rgb(0 0 0 / 2%);
                }
                .content-page .content {
                    margin-top: 50px;
                }
                .page-title span{
                    display: none;
                }
                .page-title::after{
                    content: attr(data-text-content);
                }
            }            
        </style>

        @stack('styles')
        @stack('scripts.head')
    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="user-box">   
                        <div class="user-img">
                            <a href="#" class="text-light">
                                {{ env('APP_NAME', 'Tu empresa') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">

                        <!-- Page title -->
                        <ul class="nav navbar-nav list-inline navbar-left">
                            <li class="list-inline-item">
                                <button class="button-menu-mobile open-left">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                            <li class="list-inline-item">
                                <h4 class="page-title" style="display: inline-block; margin-left: 7px;" data-text-content="{{ Str::limit($section ?? 'Admin-'.config('app.name'), 20) }}">
                                    <span>{{ $section ?? 'Admin-'.config('app.name') }}</span>
                                </h4>
                                <div id="global-loading-state-id" style="display: none;">
                                    <x-loading class="ml-2"/>
                                </div>
                            </li>                            
                        </ul>
                        

                        <nav class="navbar-custom">
                            <ul class="list-unstyled topbar-right-menu float-right mb-0">                            
                                <li>
                                    <!-- Notification -->
                                    <div class="notification-box">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a href="javascript:void(0);" class="right-bar-toggle">
                                                    <i class="mdi mdi-bell-outline noti-icon"></i>
                                                </a>
                                                <div class="noti-dot">
                                                    <span class="dot"></span>
                                                    <span class="pulse"></span>
                                                </div>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-flash noti-icon" style="color: #000836 !important;"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                  <a class="dropdown-item" href="#">Cotización rápida</a>
                                                  <div class="dropdown-divider"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- End Notification bar -->
                                </li>                                

                                {{-- <li class="hide-phone">
                                    <form class="app-search">
                                        <input type="text" placeholder="Search..."
                                               class="form-control">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </li> --}}

                            </ul>
                        </nav>
                        
                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <!-- User -->
                    <div class="user-box">
                        <div class="user-img">
                            <img src="#" alt="user avatar" title="nombre de usuario" class="rounded-circle img-thumbnail img-responsive">
                            <div class="user-status online"><i class="mdi mdi-adjust"></i></div>
                        </div>
                        <h5><a href="#">Nombre de usuario</a> </h5>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="#" >
                                    <i class="mdi mdi-settings"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a href="#" class="text-custom">
                                    <i class="mdi mdi-power"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End User -->

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul>
                        	<li class="text-muted menu-title">Navegación</li>                                                    
                            <li><a href="#" class="waves-effect"><i class="mdi mdi-account"></i><span>Opcion</span></a></li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect bg-blackpanel"><span>Opciones </span> <span class="dripicons-chevron-right"></span></a>
                                <ul class="list-unstyled"> 
                                    <li>
                                        <a href="#" class="waves-effect bg-blackpanel"> <span> opcion 1 </span> </a>
                                    </li>                                                                   
                                </ul>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                </div>

            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <div>
                            <x-alert flash="success" class="alert-success alert-auto-fadeout" />
                            <x-alert flash="error" class="alert-danger alert-auto-fadeout" />
                        </div>
                        
                        @yield('content')

                        {{ $slot ?? ''}}

                        <x-modal id="modal-files-manager-preview-file-id" data-backdrop="static">                           
                            @livewire('files-manager-view-file',[
                                'modalId' => '#modal-files-manager-preview-file-id'
                            ])
                        </x-modal>

                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
                    {{ env('APP_NAME') }}
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="mdi mdi-close-circle-outline"></i>
                </a>
                <h4 class="">Notifications</h4>
                <div class="notification-list nicescroll">
                    <ul class="list-group list-no-border user-list">
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="avatar">
                                    <img src="#" alt="avatar">
                                </div>
                                <div class="user-desc">
                                    <span class="name">Michael Zenaty</span>
                                    <span class="desc">There are new settings available</span>
                                    <span class="time">2 hours ago</span>
                                </div>
                            </a>
                        </li>                       

                    </ul>
                </div>
            </div>
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->


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
                
        <!-- Axios -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <!-- SweetAlert -->
        <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.9/dist/sweetalert2.all.min.js"></script>
        <!-- Toastr -->
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <!-- Select2 -->
        {{-- <script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

        <!-- App js -->
        <script src="{{ asset('vendor/adminto/js/jquery.core.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.app.js') }}"></script>
        
        <!-- Develper global scripts -->
        <script defer src="{{ asset('vendor/laravel-starter/js/global.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/sweet-alert2.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/toastr-config.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/modals.js') }}"></script>

        {{-- Select2 --}}
        {{-- <script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

        <!-- Bootstrap tooltip themes -->
        <script defer src="{{ asset('vendor/laravel-starter/js/bootstrap_tooltip_themes-v1.3.js') }}"></script>

        <script defer>
            // Fix dropdown-menu inside of bootstrap table
            // Moving the dropdown container outside of the table
            var dropdownMenu;  

            $('.table').on('show.bs.dropdown', function (e) {
                var target   = $(e.target);
                dropdownMenu = target.find('.dropdown-menu');

                $('body').append(dropdownMenu.detach());

                var eOffset = target.offset();
                
                dropdownMenu.css({
                    'display': 'block',
                    'top': eOffset.top + target.outerHeight(),
                    'left': eOffset.left,
                    'font-size':'14px'
                });

                dropdownMenu.addClass("mobPosDropdown");
            });
                
            $('.table').on('hide.bs.dropdown', function (e) {
                $(e.target).append(dropdownMenu.detach());
                dropdownMenu.hide();
            });
        </script>

        @jsUrlScript()
        @stack('scripts.beforeLivewire')
        @livewireScripts
        @stack('scripts')
    </body>
</html>