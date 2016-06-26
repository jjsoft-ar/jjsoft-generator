<?php

namespace JJSoft\Generator\Generators\API;

use JJSoft\Generator\Common\CommandData;
use JJSoft\Generator\Generators\BaseGenerator;
use JJSoft\Generator\Utils\FileUtil;
use JJSoft\Generator\Utils\TemplateUtil;

class APITestGenerator extends BaseGenerator
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
        $this->path = $commandData->config->pathApiTests;
        $this->fileName = $this->commandData->modelName.'ApiTest.php';
    }

    public function generate()
    {
        $templateData = TemplateUtil::getTemplate('api.test.api_test', 'jjsoft-generator');

        $templateData = TemplateUtil::fillTemplate($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandObj->comment("\nApiTest created: ");
        $this->commandData->commandObj->info($this->fileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('API Test file deleted: '.$this->fileName);
        }
    }
}
