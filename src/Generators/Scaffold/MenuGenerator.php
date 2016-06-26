<?php

namespace JJSoft\Generator\Generators\Scaffold;

use Illuminate\Support\Str;
use JJSoft\Generator\Common\CommandData;
use JJSoft\Generator\Generators\BaseGenerator;
use JJSoft\Generator\Utils\TemplateUtil;

class MenuGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $templateType;

    /** @var string */
    private $menuContents;

    /** @var string */
    private $menuTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = config(
            'jjsoft.jjsoft_generator.path.views',
            base_path('resources/views/'
            )
        ).$commandData->getAddOn('menu.menu_file');
        $this->templateType = config('jjsoft.jjsoft_generator.templates', 'core-templates');

        $this->menuContents = file_get_contents($this->path);

        $this->menuTemplate = TemplateUtil::getTemplate('scaffold.layouts.menu_template', $this->templateType);

        $this->menuTemplate = TemplateUtil::fillTemplate($this->commandData->dynamicVars, $this->menuTemplate);
    }

    public function generate()
    {
        $this->menuContents .= $this->menuTemplate.infy_nl();

        file_put_contents($this->path, $this->menuContents);
        $this->commandData->commandComment("\n".$this->commandData->config->mCamelPlural.' menu added.');
    }

    public function rollback()
    {
        if (Str::contains($this->menuContents, $this->menuTemplate)) {
            $this->commandData->commandComment('menu deleted');
        }
    }
}
