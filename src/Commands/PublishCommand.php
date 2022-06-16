<?php

namespace BlackSpot\Starter\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'laravel-starter:publish 
        { --t|theme?=adminto-bootstrap-4 : The views theme should be published (layouts)},
        { --essentials : The laravel starter essentials },
        { --db|database : Indicates if laravel-starter\'s database should be published },
        { --auth : Indicates if all auth files (login, register) should be published },
        { --bc|blade-components : Indicates if laravel-starter\'s components should be published (only for view the attributes, changes not be considered) },
        { --vs|views-structure : Indicates if the laravel-starter\'s views structure should be published },
        { --for-empty-project : All files, components and options should be published }';

    protected $description = 'Publish Laravel Starter configuration';

    public function handle()
    {
        $this->publishAdmintoBootstrap4Theme();

        if ($this->option('blade-components') || $this->option('bc')) {
            $this->publishBladeComponents();
        } elseif ($this->option('database') || $this->option('db')) {
            $this->publishDatabase();
        }elseif ($this->option('auth')) {
            $this->publishAuthFiles();
        } else if ($this->option('essentials')) {
            $this->publishEssentials();
        }elseif ($this->option('views-structure') || $this->option('vs')) {
            $this->publishViewsStructure();
        }else if ($this->option('for-empty-project')) {
            $this->publishEssentials();
            $this->publishBladeComponents();
            $this->publishDatabase();
            $this->publishAuthFiles();
            $this->publishViewsStructure();
        } else{
            $this->info('No --option found');
        }   
    }

    public function publishViewsStructure()
    {
        $this->call('vendor:publish', ['--tag' => 'laravel-starter:views-structure', '--force' => true]);
    }

    public function publishEssentials()
    {
        $this->call('vendor:publish', ['--tag' => 'laravel-starter:essentials', '--force' => true]);
    }

    public function publishAdmintoBootstrap4Theme()
    {
        if ($this->hasArgument('theme')) {
            if ($this->argument('theme') == 'adminto-bootstrap-4') {
                $this->call('vendor:publish', ['--tag' => 'laravel-starter:adminto-bootstrap-4-theme', '--force' => true]);
            }
        }else{
            $this->call('vendor:publish', ['--tag' => 'laravel-starter:adminto-bootstrap-4-theme', '--force' => true]);
        }
    }

    public function publishBladeComponents()
    {
        $this->call('vendor:publish', ['--tag' => 'laravel-starter:blade-components', '--force' => true]);
    }

    public function publishDatabase()
    {
        $this->call('vendor:publish', ['--tag' => 'laravel-starter:database', '--force' => true]);
    }
    public function publishAuthFiles()
    {
        $this->call('vendor:publish', ['--tag' => 'laravel-starter:auth', '--force' => true]);   
    }    
}
