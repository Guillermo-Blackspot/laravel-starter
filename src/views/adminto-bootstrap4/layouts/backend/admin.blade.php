<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link rel="shortcut icon" href="{{ asset('vendor/adminto/images/favicon.ico') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <title>{{ $section ?? 'Admin - '.config('app.name') }}</title>
        
        <link rel="shortcut icon" href="{{ asset('vendor/adminto/images/favicon.ico') }}">
        <!-- Toastr -->
        <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{ asset('vendor/adminto/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/adminto/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/adminto/css/style.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ asset('vendor/adminto/js/modernizr.min.js') }}"></script>

        <!-- Develper global styles -->
        <link rel="stylesheet" href="{{ asset('vendor/laravel-starter/css/global/global.css') }}" type="text/css">

        @livewireStyles
        @stack('styles')
        @stack('scripts.head')
        <style>
            .topbar .topbar-left, .navbar-default{
                border-top: none !important;
            }


            .top-bar-left, 
            .side-menu,
            .topbar .topbar-left,
            ul li a.waves-effect
            {
                /** rgb(0 6 57) **/
                background-color: rgb(0 6 57) !important;
                color: rgb(144 151 167) !important;
            }
            ul li a.waves-effect:hover{
                color: #fff !important;
            }
            .simple-filter-colors{
                background-color: rgb(91 105 188) !important;
                color: #fff !important;
            }
            
            #wrapper.enlarged .left.side-menu #sidebar-menu > ul > li > a:hover {
                /* background-color: var(--success) !important;
                color: rgb(255 255 255) !important; */
                background-color: rgb(0 6 57) !important;
                color: #ffffff !important;
            }
            .modal-body{
                padding: 0px !important;
            }
        </style>
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
                            Your logo
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
                                <h4 class="page-title">{{ $section??'Admin-'.config('app.name') }}</h4>
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
                                        </ul>
                                    </div>
                                    <!-- End Notification bar -->
                                </li>                                

                                <li class="hide-phone">
                                    <form class="app-search">
                                        <input type="text" placeholder="Search..."
                                               class="form-control">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </li>

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
                            <img src="{{ user()->photo_link }}" alt="user-img" title="{{ user()->name }}" class="rounded-circle img-thumbnail img-responsive">
                            <div class="user-status online"><i class="mdi mdi-adjust"></i></div>
                        </div>
                        <h5><a href="#">{{ user()->name }}</a> </h5>
                        <!--ul class="list-inline">
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
                        </ul-->
                    </div>
                    <!-- End User -->

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul>
                        	<li class="text-muted menu-title">Navegación</li>                                                    
                            <li>
                                <a href="#" class="waves-effect"><i class="mdi mdi-account"></i><span>Usuarios </span></a>
                            </li>                            
                            <li>
                                <a href="#" class="waves-effect"><i class="dripicons-exit"></i><span>Cerrar sesión </span></a>
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

                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
                    {{ config('app.name') }}
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
                                    <img src="{{ asset('vendor/adminto/images/users/avatar-2.jpg') }}" alt="">
                                </div>
                                <div class="user-desc">
                                    <span class="name">Michael Zenaty</span>
                                    <span class="desc">There are new settings available</span>
                                    <span class="time">2 hours ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="icon bg-info">
                                    <i class="mdi mdi-account"></i>
                                </div>
                                <div class="user-desc">
                                    <span class="name">New Signup</span>
                                    <span class="desc">There are new settings available</span>
                                    <span class="time">5 hours ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="icon bg-pink">
                                    <i class="mdi mdi-comment"></i>
                                </div>
                                <div class="user-desc">
                                    <span class="name">New Message received</span>
                                    <span class="desc">There are new settings available</span>
                                    <span class="time">1 day ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item active">
                            <a href="#" class="user-list-item">
                                <div class="avatar">
                                    <img src="{{ asset('vendor/adminto/images/users/avatar-3.jpg') }}" alt="">
                                </div>
                                <div class="user-desc">
                                    <span class="name">James Anderson</span>
                                    <span class="desc">There are new settings available</span>
                                    <span class="time">2 days ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item active">
                            <a href="#" class="user-list-item">
                                <div class="icon bg-warning">
                                    <i class="mdi mdi-settings"></i>
                                </div>
                                <div class="user-desc">
                                    <span class="name">Settings</span>
                                    <span class="desc">There are new settings available</span>
                                    <span class="time">1 day ago</span>
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

        <!-- SweetAlert -->
        <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.9/dist/sweetalert2.all.min.js"></script>
        <!-- Toastr -->
        <script defer src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
        
        <!-- App js -->
        <script src="{{ asset('vendor/adminto/js/jquery.core.js') }}"></script>
        <script src="{{ asset('vendor/adminto/js/jquery.app.js') }}"></script>

        <!-- Axios -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>        
        <!-- Develper global scripts -->
        <script defer src="{{ asset('vendor/laravel-starter/js/global/global.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/global/sweet-alert2.js') }}"></script>
        <script defer src="{{ asset('vendor/laravel-starter/js/global/toastr-config.js') }}"></script>
        @livewireScripts
        @stack('scripts')
    </body>
</html>