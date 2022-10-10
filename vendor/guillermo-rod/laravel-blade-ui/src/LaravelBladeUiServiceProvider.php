<?php 

namespace GuillermoRod\BladeUi;

use GuillermoRod\BladeUi\Components\BladeUiComponent;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class LaravelBladeUiServiceProvider extends ServiceProvider
{
    public const PACKAGE_NAME = 'laravel-blade-ui';
    public const AUTHOR       = 'Guillermo Rodriguez';
    public const VERSION      = 'v1.0.0-bootstrap4';

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
        $this->registerViews();
        $this->registerBladeComponents();
        $this->registerPublishables();
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', self::PACKAGE_NAME);
    }

    protected function registerBladeComponents()
    {        
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $prefix = config('blade-ui.prefix', 'bui');

            if ($prefix == BladeUiComponent::NULL_PREFIX) {
                $prefix = '';
            }

            /** @var BladeComponent $component */
            foreach (config('blade-ui.components', []) as $alias => $component) {
                $blade->component($component, $alias, $prefix);
            }
        });
    }

    protected function registerPublishables()
    {
        //php artisan vendor:publish --tag=laravel-blade-ui-config

        $this->publishes([
            __DIR__ . '/../config/blade-ui.php' => $this->app->configPath('blade-ui.php')
        ],['blade-ui-config','laravel-blade-ui-config']);

        $this->publishes([
            __DIR__ . '/../resources/views' => $this->app->resourcePath('views/vendor/laravel-blade-ui')
        ], ['blade-ui-config','laravel-blade-ui-components']);
    }

}
