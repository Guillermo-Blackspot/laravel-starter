<?php

namespace MmoAndFriends\Mexico\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'mexico:publish 
        { --js : Indica si main.min.js debe ser publicado. }';


    protected $description = 'Publicar el main.min.js';

    public function handle()
    {
        if ($this->option('js')) {
            $this->publishJs();
        }else{
            $this->info('No --option found');
        }
    }

    public function publishJs()
    {
        $this->call('vendor:publish', ['--tag' => 'mexico:js', '--force' => true]);
    }

    
}
