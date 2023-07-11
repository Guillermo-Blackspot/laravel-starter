<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-300">
    <div class="mx-5 mt-10 lg:mx-20 lg:px-15 grid grid-cols-1 place-items-center">
        <div class="w-full md:w-2/3 lg:w-1/2">
            <form action="{{ route('auth.login.post') }}" method="post" class="border px-10 pb-10 bg-white rounded-lg">
                <div class="text-center my-6">
                    <h4 class="text-2xl">Iniciar sesión</h4>
                </div>
                <!-- @csrf -->
                <label class="block">
                    <span class="inline font-medium text-base text-slate-700">Email <span class="text-red-400">*</span></span>
                    <!-- @error('email')<div class="inline text-red-400">{{ $message }}</div>@enderror -->
                    <input class="w-full border border-blue-200 rounded-sm p-2 mt-3 focus:outline-none focus:ring focus:ring-blue-300" name="email" type="email" required value="{{ old('email') }}">
                </label>

                <label class="block mt-3">
                    <span class="inline font-medium text-base text-slate-700">Password <span class="text-red-400">*</span></span>
                    <!-- @error('password')<div class="inline text-red-400">{{ $message }}</div>@enderror -->
                    <input class="w-full border border-blue-200 rounded-sm p-2 mt-3 focus:outline-none focus:ring focus:ring-blue-300" name="password" type="password" required="" value="{{ old('password') }}">
                </label>

                <div class="mt-4">
                    <input id="checkbox-signup" type="checkbox" name="remember">
                    <label for="checkbox-signup" class="text-base font-medium text-slate-700">Recuérdame</label>
                </div>

                <div class="mt-7">
                    <button class="rounded-sm bg-blue-600 text-white p-3 w-full focus:ring focus:ring-blue-300 active:ring active:ring-blue-300 hover:bg-slate-700 rounded-md text-lg" type="submit">Iniciar sesión</button>
                </div>

                <div class="mt-7 w-full text-center">
                        <a href="#" class="text-gray-400 font-medium underline underline-offset-8">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- end card-box-->

    <div class="w-full text-center mt-10">
        <p class="text-gray-800">¿No tienes una cuenta? <a href="#" class="text-blue-800 ml-1"><b>Registrarse</b></a></p>
    </div>
</body>
</html>