<?php

namespace JJSoft\Generator\Commands\Publish;

class PublishTemplateCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jjsoft.publish:templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes api generator templates.';

    private $templatesDir;

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->templatesDir = config(
            'jjsoft.jjsoft_generator.path.templates_dir',
            base_path('resources/jjsoft/jjsoft-generator-templates/')
        );

        if ($this->publishGeneratorTemplates()) {
            $this->publishScaffoldTemplates();
        }
    }

    /**
     * Publishes templates.
     */
    public function publishGeneratorTemplates()
    {
        $templatesPath = __DIR__.'/../../../templates';

        return $this->publishDirectory($templatesPath, $this->templatesDir, 'jjsoft-generator-templates');
    }

    /**
     * Publishes templates.
     */
    public function publishScaffoldTemplates()
    {
        $templateType = config('jjsoft.jjsoft_generator.templates', 'core-templates');

        $templatesPath = base_path('vendor/jjsoft/'.$templateType.'/templates/scaffold');

        return $this->publishDirectory($templatesPath, $this->templatesDir.'/scaffold', 'jjsoft-generator-templates/scaffold', true);
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
