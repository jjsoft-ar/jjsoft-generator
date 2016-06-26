<?php

namespace JJSoft\Generator\Commands\Publish;

use JJSoft\Generator\Utils\FileUtil;
use JJSoft\Generator\Utils\TemplateUtil;

class GeneratorPublishCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jjsoft:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes & init api routes, base controller, base test cases traits.';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->publishAPIRoutes();
        $this->initAPIRoutes();
        $this->publishTestCases();
        $this->publishBaseController();
    }

    /**
     * Publishes api_routes.php.
     */
    public function publishAPIRoutes()
    {
        $routesPath = __DIR__.'/../../../templates/api/routes/api_routes.stub';

        $apiRoutesPath = config('jjsoft.jjsoft_generator.path.api_routes', app_path('Http/api_routes.php'));

        $this->publishFile($routesPath, $apiRoutesPath, 'api_routes.php');
    }

    /**
     * Initialize routes group based on route integration.
     */
    private function initAPIRoutes()
    {
        $path = config('jjsoft.jjsoft_generator.path.routes', app_path('Http/routes.php'));

        $prompt = 'Existing routes.php file detected. Should we add an API group to the file? (y|N) :';
        if (file_exists($path) && !$this->confirmOverwrite($path, $prompt)) {
            return;
        }

        $routeContents = file_get_contents($path);

        $template = 'api.routes.api_routes_group';

        $templateData = TemplateUtil::getTemplate($template, 'jjsoft-generator');

        $templateData = $this->fillTemplate($templateData);

        file_put_contents($path, $routeContents."\n\n".$templateData);
        $this->comment("\nAPI group added to routes.php");
    }

    private function publishTestCases()
    {
        $traitPath = __DIR__.'/../../../templates/test/api_test_trait.stub';

        $testsPath = config('jjsoft.jjsoft_generator.path.api_test', base_path('tests/'));

        $this->publishFile($traitPath, $testsPath.'ApiTestTrait.php', 'ApiTestTrait.php');

        if (!file_exists($testsPath.'traits/')) {
            mkdir($testsPath.'traits/');
            $this->info('traits directory created');
        }
    }

    private function publishBaseController()
    {
        $templateData = TemplateUtil::getTemplate('app_base_controller', 'jjsoft-generator');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = config('jjsoft.jjsoft_generator.path.controller', app_path('Http/Controllers/'));

        $fileName = 'AppBaseController.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('AppBaseController created');
    }

    /**
     * Replaces dynamic variables of template.
     *
     * @param string $templateData
     *
     * @return string
     */
    private function fillTemplate($templateData)
    {
        $apiVersion = config('jjsoft.jjsoft_generator.api_version', 'v1');
        $apiPrefix = config('jjsoft.jjsoft_generator.api_prefix', 'api');
        $apiNamespace = config(
            'jjsoft.jjsoft_generator.namespace.api_controller',
            'App\Http\Controllers\API'
        );

        $templateData = str_replace('$API_VERSION$', $apiVersion, $templateData);
        $templateData = str_replace('$NAMESPACE_API_CONTROLLER$', $apiNamespace, $templateData);
        $templateData = str_replace('$API_PREFIX$', $apiPrefix, $templateData);
        $templateData = str_replace(
            '$NAMESPACE_CONTROLLER$',
            config('jjsoft.jjsoft_generator.namespace.controller'), $templateData
        );

        return $templateData;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}
