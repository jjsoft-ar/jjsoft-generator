<?php

namespace JJSoft\Generator\Commands\Scaffold;

use JJSoft\Generator\Commands\BaseCommand;
use JJSoft\Generator\Common\CommandData;
use JJSoft\Generator\Generators\Scaffold\ControllerGenerator;

class ControllerGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jjsoft.scaffold:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controller command';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        $controllerGenerator = new ControllerGenerator($this->commandData);
        $controllerGenerator->generate();

        $this->performPostActions();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), []);
    }
}
