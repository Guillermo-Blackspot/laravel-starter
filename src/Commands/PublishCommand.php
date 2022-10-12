<?php

namespace BlackSpot\Starter\Commands;

use BlackSpot\Starter\LaravelStarterServiceProvider;
use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'laravel-starter:publish 
        { --essentials : The laravel starter essentials (assets, default files manager resources, config files, starter login) },
        { --assets : Indicates if the assets should be published},
        { --views-structure : Indicates if the views structure should be published },
        { --auth : Indicates if all auth files (controller and routes) should be published },
        { --database : Indicates if database resources should be published (models, migrations and seeders) },
        { --empty-project : All resources, assets and options should be published for an empty project },
        { --theme= : Default theme adminto-bootstrap-4}';

    protected $description = 'Publish Laravel Starter configuration';

    public function handle()
    {   
        if ($this->option('assets')) $this->publishAssets();

        if ($this->option('essentials')) $this->publishEssentials();
        
        if ($this->option('views-structure')) $this->publishViewsStructure();

        if ($this->option('auth')) $this->publishAuthFiles();

        if ($this->option('database')) $this->publishDatabase();

        // if ($this->option('blade-themes')) $this->publishBladeThemes();
        
        if ($this->option('empty-project')) {
            $this->publishEssentials();
            $this->publishViewsStructure();
            $this->publishAuthFiles();
            $this->publishDatabase();
            //$this->publishAssets();
        }
        
        $this->resolveThemeToPublish();
    }

    public function publishAssets()
    {
        $this->call('vendor:publish', ['--tag' => $this->getPackageName('-assets'), '--force' => true]);
    }

    public function publishEssentials()
    {
        $this->publishAssets();
        $this->call('vendor:publish', ['--tag' => $this->getPackageName('-essentials'), '--force' => false]);
    }

    public function publishViewsStructure()
    {
        $this->call('vendor:publish', ['--tag' => $this->getPackageName('-views-structure'), '--force' => false]);
    }

    public function publishAuthFiles()
    {
        $this->call('vendor:publish', ['--tag' => $this->getPackageName('-auth'), '--force' => false]);   
    }    

    public function publishDatabase()
    {
        $this->call('vendor:publish', ['--tag' => $this->getPackageName('-database'), '--force' => false]);
    }

    // public function publishBladeThemes()
    // {
    //     $this->call('vendor:publish', ['--tag' => $this->getPackageName(':blade-themes'), '--force' => false]);
    // }

    public function resolveThemeToPublish()
    {
        if (!$this->option('theme')) return;

        if ($this->option('theme') == null || $this->option('theme') == 'adminto-bootstrap-4') $this->publishAdmintoBootstrap4Theme(); // default
    }    

    public function publishAdmintoBootstrap4Theme()
    {
        $this->call('vendor:publish', ['--tag' => $this->getPackageName('-adminto-bootstrap-4-resources'), '--force' => false]);
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
        $name = LaravelStarterServiceProvider::PACKAGE_NAME;

        if (!empty($join)) $name .= $join;

        return $name;
    }
}
