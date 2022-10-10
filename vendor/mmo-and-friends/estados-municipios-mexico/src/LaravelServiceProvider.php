<?php

namespace MmoAndFriends\Mexico;

use Illuminate\Support\ServiceProvider;
use MmoAndFriends\Mexico\Commands\PublishCommand;

class LaravelServiceProvider extends ServiceProvider
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
        $this->registerCommands();
        $this->registerPublishables();
    }

    protected function registerPublishables()
    {

        /**
         * Assets js
         */
        $this->publishesToGroups([            
            __DIR__.'/../dist/estados_municipios_mexico.min.js' => public_path('vendor/estados-municipios-mexico/estados_municipios_mexico.min.js')
        ], ['mexico', 'mexico:js']);
    }


    protected function registerCommands()
    {
        if (! $this->app->runningInConsole()) return;

        $this->commands([            
            PublishCommand::class,  // mexico:publish
        ]);

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
