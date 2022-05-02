@extends('app.layouts.frontend.public')

@section('content')
    <div class="account-pages" style="background-image: none"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page">
        {{-- <div class="text-center">
            <h5 class="text-muted m-t-0 font-600"></h5>
        </div> --}}
        <div class="m-t-40 card-box">
            <div class="text-center">
                <h4 class="text-uppercase font-bold m-b-0">Iniciar sesión</h4>
            </div>
            <div class="p-20">
                <form class="form-horizontal m-t-20" action="{{ route('auth.login.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        @error('email')
                            <div class="col-xs-12 text-danger">{{ $message }}</div>
                        @enderror
                        <div class="col-xs-12">
                            <input class="form-control" name="email" type="email" required placeholder="Email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        @error('password')
                            <div class="col-xs-12 text-danger">{{ $message }}</div>
                        @enderror
                        <div class="col-xs-12">
                            <input class="form-control" name="password" type="password" required="" placeholder="Contraseña" value="{{ old('password') }}">
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-custom">
                                <input id="checkbox-signup" type="checkbox" name="remember">
                                <label for="checkbox-signup">
                                    Recuérdame
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group text-center m-t-30">
                        <div class="col-xs-12">
                            <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">Iniciar sesión</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-sm-12">
                            <a href="page-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> ¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- end card-box-->

        <div class="row">
            <div class="col-sm-12 text-center">
                <p class="text-muted">¿No tienes una cuenta? <a href="page-register.html" class="text-primary m-l-5"><b>Registrarse</b></a></p>
            </div>
        </div>
        
    </div>
    <!-- end wrapper page -->
@endsection