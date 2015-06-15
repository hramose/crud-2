<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.04.02.
 * Time: 7:12
 */

namespace BlackfyreStudio\CRUD\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ScaffoldCommand extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud:scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new set of Models, Controllers and Migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        //

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the module you wish to create'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}