<?php

namespace JJSoft\Generator;

use Illuminate\Support\ServiceProvider;
use JJSoft\Generator\Commands\API\APIControllerGeneratorCommand;
use JJSoft\Generator\Commands\API\APIGeneratorCommand;
use JJSoft\Generator\Commands\API\APIRequestsGeneratorCommand;
use JJSoft\Generator\Commands\API\TestsGeneratorCommand;
use JJSoft\Generator\Commands\APIScaffoldGeneratorCommand;
use JJSoft\Generator\Commands\Common\MigrationGeneratorCommand;
use JJSoft\Generator\Commands\Common\ModelGeneratorCommand;
use JJSoft\Generator\Commands\Common\RepositoryGeneratorCommand;
use JJSoft\Generator\Commands\Publish\GeneratorPublishCommand;
use JJSoft\Generator\Commands\Publish\LayoutPublishCommand;
use JJSoft\Generator\Commands\Publish\PublishTemplateCommand;
use JJSoft\Generator\Commands\RollbackGeneratorCommand;
use JJSoft\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use JJSoft\Generator\Commands\Scaffold\RequestsGeneratorCommand;
use JJSoft\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use JJSoft\Generator\Commands\Scaffold\ViewsGeneratorCommand;

class JJSoftGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/jjsoft_generator.php';

        $this->publishes([
            $configPath => config_path('jjsoft/jjsoft_generator.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('jjsoft.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('jjsoft.api', function ($app) {
            return new APIGeneratorCommand();
        });

        $this->app->singleton('jjsoft.scaffold', function ($app) {
            return new ScaffoldGeneratorCommand();
        });

        $this->app->singleton('jjsoft.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('jjsoft.publish.templates', function ($app) {
            return new PublishTemplateCommand();
        });

        $this->app->singleton('jjsoft.api_scaffold', function ($app) {
            return new APIScaffoldGeneratorCommand();
        });

        $this->app->singleton('jjsoft.migration', function ($app) {
            return new MigrationGeneratorCommand();
        });

        $this->app->singleton('jjsoft.model', function ($app) {
            return new ModelGeneratorCommand();
        });

        $this->app->singleton('jjsoft.repository', function ($app) {
            return new RepositoryGeneratorCommand();
        });

        $this->app->singleton('jjsoft.api.controller', function ($app) {
            return new APIControllerGeneratorCommand();
        });

        $this->app->singleton('jjsoft.api.requests', function ($app) {
            return new APIRequestsGeneratorCommand();
        });

        $this->app->singleton('jjsoft.api.tests', function ($app) {
            return new TestsGeneratorCommand();
        });

        $this->app->singleton('jjsoft.scaffold.controller', function ($app) {
            return new ControllerGeneratorCommand();
        });

        $this->app->singleton('jjsoft.scaffold.requests', function ($app) {
            return new RequestsGeneratorCommand();
        });

        $this->app->singleton('jjsoft.scaffold.views', function ($app) {
            return new ViewsGeneratorCommand();
        });

        $this->app->singleton('jjsoft.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->commands([
            'jjsoft.publish',
            'jjsoft.api',
            'jjsoft.scaffold',
            'jjsoft.api_scaffold',
            'jjsoft.publish.layout',
            'jjsoft.publish.templates',
            'jjsoft.migration',
            'jjsoft.model',
            'jjsoft.repository',
            'jjsoft.api.controller',
            'jjsoft.api.requests',
            'jjsoft.api.tests',
            'jjsoft.scaffold.controller',
            'jjsoft.scaffold.requests',
            'jjsoft.scaffold.views',
            'jjsoft.rollback',
        ]);
    }
}
