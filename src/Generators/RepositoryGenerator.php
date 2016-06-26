<?php

namespace JJSoft\Generator\Generators;

use JJSoft\Generator\Common\CommandData;
use JJSoft\Generator\Utils\FileUtil;
use JJSoft\Generator\Utils\TemplateUtil;

class RepositoryGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $fileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathRepository;
        $this->fileName = $this->commandData->modelName.'Repository.php';
    }

    public function generate()
    {
        $templateData = TemplateUtil::getTemplate('repository', 'jjsoft-generator');

        $templateData = TemplateUtil::fillTemplate($this->commandData->dynamicVars, $templateData);

        $searchables = [];

        foreach ($this->commandData->inputFields as $field) {
            if ($field['searchable']) {
                $searchables[] = "'".$field['fieldName']."'";
            }
        }

        $templateData = str_replace('$FIELDS$', implode(','.infy_nl_tab(1, 2), $searchables), $templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandComment("\nRepository created: ");
        $this->commandData->commandInfo($this->fileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Repository file deleted: '.$this->fileName);
        }
    }
}
