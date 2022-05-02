<?php

namespace BlackSpot\Starter\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'laravel-starter:publish 
        { --t|theme?=adminto-bootstrap-4 : The views theme should be published (layouts)},
        { --essentials : The laravel starter essentials },
        { --database : Indicates if laravel-starter\'s database should be published },
        { --auth : Indicates if all auth files (login, register) should be published },
        { --blade-components : Indicates if laravel-starter\'s components should be published (only for view the attributes, changes not be considered) }';

    protected $description = 'Publish Laravel Starter configuration';

    public function handle()
    {
        if ($this->option('blade-components')) {
            $this->publishBladeComponents();
        } elseif ($this->option('database')) {
            $this->publishDatabase();
        }elseif ($this->option('auth')) {
            $this->publishAuthFiles();
        } else if ($this->option('essentials')) {
            $this->publishEssentials();
        }else {
            $this->info('No --option found');
        }

        $this->publishAdmintoBootstrap4Theme();
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
