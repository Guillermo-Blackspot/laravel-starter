# Laravel Starter

Este paquete sirve para optimizar los tiempos de progamación al inicio.
Tambien es de mucha ayuda para el crecimiento acelerado de los proyectos con Laravel.


### Instalación

 - 1 .- Debe ejecutar el siguiente comando
	 - `composer require blackspot/laravel-starter`
	 - Esto le instalará el paquete, además de los siguientes paquetes que son requeridos: livewire/livewire y mmo-and-friends/estados-municipios-mexico
	 
- 2 .- Publicar archivos
	 - `php artisan laravel-starter publish ${opciones}`
	 - Estas son las opciones que el paquete acepta
		 - `--essentials` Esta opción publica :
			 - avatars por defecto
			 - assets (toastr, sweeetAlert2, adminto bootstrap 4)
			 - archivos config de : filesmager y laravel-starter
			 - rutas por defecto
		- `--database --db(alias)` Esta opción publica:
			- modelos
			- migraciones
			- seeders
		 - `--auth` Esta opción publica:
			 - Login (vista, controlador y rutas)
		- `--views-structure --vs(alias)` Esta opción creara la estructura de carpetas para un proyecto en blanco (carpetas backend y fronted)
		- `--blade-components --bc(alias)` Esta opción publica los componentes de laravel-starter para que puedan visualizarse el código pero los cambios que se realicen no son tomados en cuenta
		- `--theme  -t(alias)` Esta opción indica el template del cual se tomaran las vistas que se creen. Por defecto es "adminto-bootstrap-4"
		- `--for-empty-project` Esta opción indica que todas las anteriores opciones serán ejecutadas ya que se esta empezando un proyecto nuevo




