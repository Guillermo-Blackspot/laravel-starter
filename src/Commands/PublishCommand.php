<?php

namespace BlackSpot\Starter\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'lstarter:publish 
        { --assets : Indicates if laravel-starter\'s front-end assets should be published },
        { --config : Indicates if laravel-starter\'s config file should be published },
        { --views-structure : Indicates if laravel-starter\'s directory structure should be published },
        { --adminto-bootstrap4 : Indicates if laravel-starter\'s adminto bootstrap4 views should be published },
        { --components : Indicates if laravel-starter\'s components should be published (only for view the attributes, changes not be considered) },
        { --database : Indicates if laravel-starter\'s database should be published },
        { --default : Indicates if laravel-starter\'s default config should be published },
        { --login : Indicates if laravel-starter\'s login should be published }';


    protected $description = 'Publish Laravel Starter configuration';

    public function handle()
    {
        if ($this->option('assets')) {
            $this->publishAssets();
        } elseif ($this->option('config')) {
            $this->publishConfig();
        } elseif ($this->option('views-structure')) {
            $this->publishViewsStructure();
        } elseif ($this->option('adminto-bootstrap4')) {
            $this->publishAdmintoBootstrap4();
        } elseif ($this->option('components')) {
            $this->publishComponents();
        } elseif ($this->option('database')) {
            $this->publishDatabase();
        }elseif ($this->option('login')) {
            $this->publishLogin();
        } else if ($this->option('default')) {
            $this->publishAssets();
            $this->publishConfig();
            $this->publishViewsStructure();
            $this->publishAdmintoBootstrap4();
            $this->publishDatabase();            
            $this->publishLogin();
        }else {
            $this->info('No --option found');
        }
    }

    public function publishAssets()
    {
        $this->call('vendor:publish', ['--tag' => 'lstarter:assets', '--force' => true]);
    }

    public function publishConfig()
    {
        $this->call('vendor:publish', ['--tag' => 'lstarter:config', '--force' => true]);
    }

    public function publishViewsStructure()
    {
        $this->call('vendor:publish', ['--tag' => 'lstarter:views-structure', '--force' => true]);
    }

    public function publishAdmintoBootstrap4()
    {
        $this->call('vendor:publish', ['--tag' => 'lstarter:adminto-bootstrap4', '--force' => true]);
    }

    public function publishComponents()
    {
        $this->call('vendor:publish', ['--tag' => 'lstarter:components', '--force' => true]);
    }

    public function publishDatabase()
    {
        $this->call('vendor:publish', ['--tag' => 'lstarter:database', '--force' => true]);
    }
    public function publishLogin()
    {
        $this->call('vendor:publish', ['--tag' => 'lstarter:login', '--force' => true]);
    }
}
