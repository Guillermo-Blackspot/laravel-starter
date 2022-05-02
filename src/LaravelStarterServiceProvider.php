<?php

namespace BlackSpot\Starter;

use BlackSpot\Starter\BladeComponents\{
    AdvancedMultiSelect,
    Alert,
    SimpleButton,
    InlineInput,
    InlineSelect,
    InlineTextarea,
    InputFilter,
    LinearInput,
    LinearSelect,
    LinearTextarea,
    Loading,
    SimpleModal,
    SimpleFilter,
    Table
};
use BlackSpot\Starter\Commands\MakeViewCommand;
use BlackSpot\Starter\Commands\PublishCommand;
use BlackSpot\Starter\Livewire\FilesManager\PreviewFile;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Livewire;

class LaravelStarterServiceProvider extends ServiceProvider
{
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
        $this->registerPublishables();
        $this->registerCommands();
        $this->registerLivewireComponents();
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-starter');
    }

    protected function registerMacros()
    {
        Str::macro('firstWhereStrpos', function ($search, $subject, &$path = null) {
            if (($index = strpos($subject, $search)) !== false) {
                $path = substr($subject, $index + 1, strlen($subject));
                return substr($subject, 0, $index);
            }
            return $subject;
        });

        Str::macro('lastWhereStrpos', function ($search, $subject, &$path = null) {
            if (($index = strrpos($subject, $search)) !== false) {
                $path = substr($subject, 0, $index);
                return substr($subject, $index + 1, strlen($subject));
            }
            return $subject;
        });

        Str::macro('randomLetters', function ($length = 16) {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
            //return preg_replace('/^([0-9]* \w+ )?(.*)$/', '$2', Str::random($size));
        });
        Arr::macro('every', function ($array, $callback) {
            foreach ($array as $key => $value) {
                if (!$callback($value, $key)) return false;
            }
            return true;
        });
        Arr::macro('some', function ($array, $callback) {
            foreach ($array as $key => $value) {
                if ($callback($value, $key)) return true;
            }
            return false;
        });

        DB::query()->macro('firstOrFail', function () {
            if ($record = $this->first()) {
                return $record;
            }
            abort(404, 'Not found!');
        });
    }

    protected function registerBladeComponents()
    {
        $this->loadViewComponentsAs('', [
            SimpleButton::class,
            //Forms
            InlineInput::class,
            InlineSelect::class,
            InlineTextarea::class,
            LinearInput::class,
            LinearSelect::class,
            LinearTextarea::class,
            //Advanced Forms
            AdvancedMultiSelect::class,
            //Modals
            SimpleModal::class,
            //Tables and for tables
            SimpleFilter::class,
            Table::class,
            InputFilter::class,
            //Miscellaneous
            Alert::class,
            Loading::class
        ]);
    }


    protected function registerPublishables()
    {

        $this->publishesToGroups([

            /***
             * Assets (js,css,img, ...)
             */
            __DIR__ . '/../adminto'               => public_path('vendor/adminto'),
            __DIR__ . '/../laravel-starter'       => public_path('vendor/laravel-starter'),
            __DIR__ . '/../toastr'                => public_path('vendor/toastr'),
            __DIR__ . '/../storage/files-manager' => storage_path('app/files-manager'),

            /**
             * Configs
             */
            __DIR__ . '/../config/filesmanager.php'                       => base_path('config/filesmanager.php'),
            __DIR__ . '/../config/laravel-starter.php'                    => base_path('config/laravel-starter.php'),
            __DIR__ . '/Livewire/FilesManager/bootstrap-layout.blade.php' => class_exists('Livewire\Livewire') ? resource_path('views/livewire/addons/files-manager/bootstrap-layout.blade.php') : '',

            /**
             * Routes
             */
            __DIR__ . '/../routes/defaults.php' => base_path('routes/web.php'),

        ], ['laravel-starter', 'laravel-starter:essentials']);



        /**
         * Views structure
        */
        $this->publishes([
            __DIR__ . '/views/structure' => resource_path('views/'),
        ], ['laravel-starter', 'laravel-starter:views-structure']);


        /**
         * Auth controller, views and routes
         */
        $this->publishes([
            __DIR__ . '/Auth/LoginController.php' => app_path('Http/Controllers/Auth/LoginController.php'),
            __DIR__ . '/../routes/auth.php'       => base_path('routes/web.php'),
        ], ['laravel-starter', 'laravel-starter:auth']);

        /**
         * Adminto bootstrap 4 them
         */
        $this->publishes([
            __DIR__ . '/views/adminto-bootstrap4/layouts'         => resource_path('views/app/layouts/'),
            __DIR__ . '/views/adminto-bootstrap4/login.blade.php' => resource_path('views/app/auth/login.blade.php'),
        ], ['laravel-starter', 'laravel-starter:adminto-bootstrap-4-theme']);

        /**
         * Blade components
         */
        $this->publishes([
            __DIR__ . '/views/components' => resource_path('views/components/laravel-starter-themes/')
        ], ['laravel-starter', 'laravel-starter:blade-components']);

        /**
         * Database Models, Migrations and Seeders
         */
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
            __DIR__ . '/../database/seeders'    => database_path('seeders'),
            __DIR__ . '/../database/models'     => base_path('app/Models'),
        ], ['laravel-starter', 'laravel-starter:database']);        
    }


    protected function registerCommands()
    {
        if (!$this->app->runningInConsole()) return;

        $this->commands([
            PublishCommand::class,  // lstarter:publish,
            MakeViewCommand::class // lstarer:make-view
        ]);
    }

    public function registerLivewireComponents()
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

            return;
        }

        foreach ((array) $groups as $group) {
            $this->publishes($paths, $group);
        }
    }
}
