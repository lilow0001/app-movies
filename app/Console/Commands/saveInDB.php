<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MovieController;

class saveInDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:saveInDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Saving in DB...');
        $controller = new MovieController();
        $rep = $controller->saveInDB_Api();
        return $this->info($rep);
    }
}
