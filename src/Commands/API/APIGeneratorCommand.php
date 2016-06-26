<?php

namespace JJSoft\Generator\Commands\API;

use JJSoft\Generator\Commands\BaseCommand;
use JJSoft\Generator\Common\CommandData;
use JJSoft\Generator\Generators\API\APIControllerGenerator;
use JJSoft\Generator\Generators\API\APIRequestGenerator;
use JJSoft\Generator\Generators\API\APIRoutesGenerator;
use JJSoft\Generator\Generators\API\APITestGenerator;
use JJSoft\Generator\Generators\MigrationGenerator;
use JJSoft\Generator\Generators\ModelGenerator;
use JJSoft\Generator\Generators\RepositoryGenerator;
use JJSoft\Generator\Generators\RepositoryTestGenerator;
use JJSoft\Generator\Generators\TestTraitGenerator;

class APIGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jjsoft:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full CRUD API for given model';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_API);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        if (!$this->commandData->getOption('fromTable')) {
            $migrationGenerator = new MigrationGenerator($this->commandData);
            $migrationGenerator->generate();
        }

        $modelGenerator = new ModelGenerator($this->commandData);
        $modelGenerator->generate();

        $repositoryGenerator = new RepositoryGenerator($this->commandData);
        $repositoryGenerator->generate();

        $controllerGenerator = new APIControllerGenerator($this->commandData);
        $controllerGenerator->generate();

        $requestGenerator = new APIRequestGenerator($this->commandData);
        $requestGenerator->generate();

        $routesGenerator = new APIRoutesGenerator($this->commandData);
        $routesGenerator->generate();

        if ($this->commandData->getAddOn('tests')) {
            $repositoryTestGenerator = new RepositoryTestGenerator($this->commandData);
            $repositoryTestGenerator->generate();

            $testTraitGenerator = new TestTraitGenerator($this->commandData);
            $testTraitGenerator->generate();

            $apiTestGenerator = new APITestGenerator($this->commandData);
            $apiTestGenerator->generate();
        }

        $this->performPostActionsWithMigration();
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
