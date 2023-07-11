<?php

namespace BlackSpot\Starter;

use BlackSpot\Starter\BladeComponents\{
    AdvancedMultiSelect,
    InlineInput,
    InlineSelect,
    InlineTextarea,
    InputFilter,
    SimpleFilter
};


use BlackSpot\Starter\Commands\MakeViewCommand;
use BlackSpot\Starter\Commands\PublishCommand;
use BlackSpot\Starter\Livewire\FilesManager\PreviewFile;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Livewire;

class LaravelStarterServiceProvider extends ServiceProvider
{

    public const PACKAGE_NAME = 'laravel-starter';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMacros();
        $this->registerViews();
        $this->registerBladeComponents();
        $this->registerBladeDirectives();
        $this->registerPublishables();
        $this->registerCommands();
        $this->registerLivewireComponents();
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'views/shared', self::PACKAGE_NAME);
        $this->loadViewsFrom(storage_path('/app/files-manager'), 'files_manager');
    }

    /**
     * Str, Arr and DB macros
     */
    protected function registerMacros()
    {
        Str::macro('firstWhereStrpos', function ($search, $subject) {
            if (($index = strpos($subject, $search)) !== false) {
                //$path = substr($subject, $index + 1, strlen($subject));
                return substr($subject, 0, $index);
            }
            return $subject;
        });

        Str::macro('lastWhereStrpos', function ($search, $subject) {
            if (($index = strrpos($subject, $search)) !== false) {
                //$path = substr($subject, 0, $index);
                return substr($subject, $index + 1, strlen($subject));
            }
            return $subject;
        });

        Str::macro('randomLetters', function ($length = 23) {
            $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString     = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            return $randomString;
        });

        Arr::macro('every', function ($array, $callback) {
            foreach ($array as $key => $value) {
                if (!$callback($value, $key, $array)) return false;
            }
            return true;
        });

        Arr::macro('some', function ($array, $callback) {
            foreach ($array as $key => $value) {
                if ($callback($value, $key, $array)) return true;
            }
            return false;
        });

        DB::query()->macro('firstOrFail', function () {
            if ($record = $this->first()) return $record;
            abort(404, 'Not found!');
        });
    }

    protected function registerBladeComponents()
    {        
        $this->loadViewComponentsAs(null,[
            //Forms
            InlineInput::class,
            InlineSelect::class,
            InlineTextarea::class,
            //Advanced Forms
            AdvancedMultiSelect::class,
            //Tables and for tables
            SimpleFilter::class,
            InputFilter::class,
        ]);        
    }
    

    protected function registerBladeDirectives()
    {        
        Blade::directive('jsUrlScript', [BladeDirectives::class, 'jsUrlScript']);
        Blade::directive('dispatchBrowserEventsScript', [BladeDirectives::class, 'dispatchBrowserEventsScript']);
        Blade::directive('starterScripts', [BladeDirectives::class, 'starterScripts']);
    }

    protected function registerPublishables()
    {

        $this->publishes([
            __DIR__ . '/../dist/laravel-starter' => public_path('vendor/laravel-starter'),
        ],[$this->getPackageName('-assets')]);

        $this->publishesToGroups([
            // Default assets
            __DIR__ . '/../dist/files-manager'   => storage_path('app/files-manager'),                        
            __DIR__ . '/../dist/laravel-starter' => public_path('vendor/laravel-starter'),

            // Default config files for correct functionality
            __DIR__ . '/../config/filesmanager.php'                       => base_path('config/filesmanager.php'),
            __DIR__ . '/../config/laravel-starter.php'                    => base_path('config/laravel-starter.php'),
            __DIR__ . '/Livewire/FilesManager/bootstrap-layout.blade.php' => class_exists('Livewire\Livewire') ? resource_path('views/livewire/addons/files-manager/bootstrap-layout.blade.php') : '',
            
            // Default tailwind css login
            __DIR__ . '/views/stubs/helpers/starter_login.blade.php' => resource_path('views/app/auth/starter_login.blade.php'),
        ],[
            $this->getPackageName('-essentials')
        ]);

        $this->publishes([
            
            // Views structure
            //
            // app  >
            //       auth
            //       backend  >
            //                 admin
            //                 user
            //       frontend             
            //       layouts >
            //                 backend
            //                 frontend
            //
            __DIR__ . '/views/stubs/structure' => resource_path('views/'),
        ], [
            $this->getPackageName('-views-structure')
        ]);

        $this->publishes([
            
            // Login resources
            //
            //
            __DIR__ . '/Controllers/LoginController.php' => app_path('Http/Controllers/Auth/LoginController.php'),
            __DIR__ . '/../routes/auth.php'              => base_path('routes/web.php'),
        ], [
            $this->getPackageName(':auth')
        ]);
 
        $this->publishes([
            
            // Adminto bootstrap 4 resources (assets and views)
            //
            //
            __DIR__ . '/views/stubs/adminto-bootstrap4/layouts'                 => resource_path('views/app/layouts/'),
            __DIR__ . '/views/stubs/adminto-bootstrap4/adminto_login.blade.php' => resource_path('views/app/auth/login.blade.php'),
            __DIR__ . '/../dist/adminto'                                  => public_path('vendor/adminto'),
        ], [
            $this->getPackageName('-adminto-bootstrap-4-resources')
        ]);

        // $this->publishes([
        //     // Default Blade view components
        //     //
        //     //
        //     __DIR__ . '/views/components' => resource_path('views/components/laravel-starter-themes/')
        // ], [
        //     $this->getPackageName(':blade-themes')
        // ]);

        
        $this->publishes([
            
            // Default database resources
            //
            //
            __DIR__ . '/../database/migrations' => database_path('migrations'),
            __DIR__ . '/../database/seeders'    => database_path('seeders'),
            __DIR__ . '/../database/models'     => base_path('app/Models'),
        ], [
            $this->getPackageName('-database')
        ]);

        // Model stubs
        $this->publishes([__DIR__ . '/../database/models' => base_path('app/vendor-stubs/laravel-starter/models')], [
            $this->getPackageName('-model-stubs')
        ]);
    }


    protected function registerCommands()
    {
        if (!$this->app->runningInConsole()) return;

        $this->commands([
            PublishCommand::class,  // lstarter:publish,
            //MakeViewCommand::class  // lstarer:make-view
        ]);
    }

    protected function registerLivewireComponents()
    {
        if ($this->app->runningInConsole()) return;

        if (class_exists('Livewire\Livewire')) {
            Livewire::component('files-manager-view-file', PreviewFile::class);
        }
    }

    protected function publishesToGroups(array $paths, $groups = null)
    {        
        if (is_null($groups)) {
            $this->publishes($paths);
        }else{
            foreach ((array) $groups as $group) {
                $this->publishes($paths, $group);
            }
        }

        return $this;
    }


    /**
     * Get the laravel starter name 
     * 
     * @param string $join
     * 
     * @return string
     */
    public function getPackageName(string $join = '')
    {
        $name = self::PACKAGE_NAME;

        if (!empty($join)) $name .= $join;

        return $name;
    }
}
