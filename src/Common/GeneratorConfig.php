<?php

namespace JJSoft\Generator\Common;

use Illuminate\Support\Str;

class GeneratorConfig
{
    /* Namespace variables */
    public $nsApp;
    public $nsRepository;
    public $nsModel;
    public $nsDataTables;
    public $nsModelExtend;

    public $nsApiController;
    public $nsApiRequest;

    public $nsRequest;
    public $nsRequestBase;
    public $nsController;
    public $nsBaseController;

    /* Path variables */
    public $pathRepository;
    public $pathModel;
    public $pathDataTables;

    public $pathApiController;
    public $pathApiRequest;
    public $pathApiRoutes;
    public $pathApiTests;
    public $pathApiTestTraits;

    public $pathController;
    public $pathRequest;
    public $pathRoutes;
    public $pathViews;

    /* Model Names */
    public $mName;
    public $mPlural;
    public $mCamel;
    public $mCamelPlural;
    public $mSnake;
    public $mSnakePlural;

    public $forceMigrate;

    /* Generator Options */
    public $options;

    /* Prefixes */
    public $prefixes;

    /* Command Options */
    public static $availableOptions = [
        'fieldsFile', 
        'jsonFromGUI', 
        'connectionName', 
        'tableName', 
        'moduleName', 
        'fromTable', 
        'save', 
        'primary', 
        'prefix', 
        'paginate',
        'skip',
        'datatables',
        'views'
    ];

    public $tableName;
    public $connectionName;
    public $moduleName;

    /* Generator AddOns */
    public $addOns;

    public function init(CommandData &$commandData)
    {
        $this->mName = $commandData->modelName;

        $this->prepareAddOns();
        $this->prepareOptions($commandData);
        $this->prepareModelNames();
        $this->preparePrefixes();
        $this->loadNamespaces($commandData);
        $this->loadPaths();
        $commandData = $this->loadDynamicVariables($commandData);
    }

    public function loadNamespaces(CommandData &$commandData)
    {
        $prefix = $this->prefixes['ns'];

        if (!empty($prefix)) {
            $prefix = '\\'.$prefix;
        }
        
        $module = $this->getOption('moduleName');
        if(empty($module)) {
            $module = 'App';
        }else{
            $module = 'Modules\\'.$module;
        }
        config([
            'jjsoft.jjsoft_generator.namespace.repository' => $module.'\Repositories',
            'jjsoft.jjsoft_generator.namespace.model' => $module.'\Entities',
            'jjsoft.jjsoft_generator.namespace.datatables' => $module.'\DataTables',
            'jjsoft.jjsoft_generator.model_extend_class','Illuminate\Database\Eloquent\Model',

            'jjsoft.jjsoft_generator.namespace.api_controller' => $module.'\Http\Controllers\API',
            'jjsoft.jjsoft_generator.namespace.api_request' => $module.'\Http\Requests\API',

            'jjsoft.jjsoft_generator.namespace.request' => $module.'\Http\Requests',
            'jjsoft.jjsoft_generator.namespace.controller' => $module.'\Http\Controllers'
        ]);
        $this->nsApp = $commandData->commandObj->getLaravel()->getNamespace();
        $this->nsRepository = config('jjsoft.jjsoft_generator.namespace.repository').$prefix;
        $this->nsModel = config('jjsoft.jjsoft_generator.namespace.model').$prefix;
        $this->nsDataTables = config('jjsoft.jjsoft_generator.namespace.datatables').$prefix;
        $this->nsModelExtend = config('jjsoft.jjsoft_generator.model_extend_class','Illuminate\Database\Eloquent\Model' );

        $this->nsApiController = config('jjsoft.jjsoft_generator.namespace.api_controller').$prefix;
        $this->nsApiRequest = config('jjsoft.jjsoft_generator.namespace.api_request').$prefix;

        $this->nsRequest = config('jjsoft.jjsoft_generator.namespace.request').$prefix;
        $this->nsRequestBase = config('jjsoft.jjsoft_generator.namespace.request');
        $this->nsBaseController = config('jjsoft.jjsoft_generator.namespace.controller');
        $this->nsController = config('jjsoft.jjsoft_generator.namespace.controller').$prefix;
    }

    public function loadPaths()
    {
        $prefix = $this->prefixes['path'];

        if (!empty($prefix)) {
            $prefix .= '/';
        }

        $viewPrefix = $this->prefixes['view'];

        if (!empty($viewPrefix)) {
            $viewPrefix .= '/';
        }
        
        $module = $this->getOption('moduleName');
        
        if(empty($module)) {
            $module = '';
            $moduleModels = 'Models/';
            $moduleViews = 'resources/views/';
            $moduleTests = 'tests/';
            config([
                'jjsoft.jjsoft_generator.path.repository',app_path($module.'Repositories/'),
                'jjsoft.jjsoft_generator.path.model', app_path($moduleModels),
                'jjsoft.jjsoft_generator.path.datatables', app_path($module.'DataTables/'),
                'jjsoft.jjsoft_generator.path.api_controller',app_path($module.'Http/Controllers/API/'),
                'jjsoft.jjsoft_generator.path.api_request',app_path($module.'Http/Requests/API/'),
                'jjsoft.jjsoft_generator.path.api_routes', app_path($module.'Http/api_routes.php'),
                'jjsoft.jjsoft_generator.path.api_test', base_path($moduleTests),
                'jjsoft.jjsoft_generator.path.test_trait', base_path($moduleTests.'traits/'),
                'jjsoft.jjsoft_generator.path.controller',app_path($module.'Http/Controllers/'),
                'jjsoft.jjsoft_generator.path.request', app_path($module.'Http/Requests/'),
                'jjsoft.jjsoft_generator.path.routes', app_path($module.'Http/routes.php'),
                'jjsoft.jjsoft_generator.path.views',base_path($moduleViews)
            ]);
        }else{
            $module = 'modules/'.$module.'/';
            $moduleModels = $module . 'Entities/';
            $moduleViews = $module . 'Resources/views/';
            $moduleTests = $module . 'Tests/';
            config([
                'jjsoft.jjsoft_generator.path.repository',base_path($module.'Repositories/'),
                'jjsoft.jjsoft_generator.path.model', base_path($moduleModels),
                'jjsoft.jjsoft_generator.path.datatables', base_path($module.'DataTables/'),
                'jjsoft.jjsoft_generator.path.api_controller',base_path($module.'Http/Controllers/API/'),
                'jjsoft.jjsoft_generator.path.api_request',base_path($module.'Http/Requests/API/'),
                'jjsoft.jjsoft_generator.path.api_routes', base_path($module.'Http/api_routes.php'),
                'jjsoft.jjsoft_generator.path.api_test', base_path($moduleTests),
                'jjsoft.jjsoft_generator.path.test_trait', base_path($moduleTests.'traits/'),
                'jjsoft.jjsoft_generator.path.controller',base_path($module.'Http/Controllers/'),
                'jjsoft.jjsoft_generator.path.request', base_path($module.'Http/Requests/'),
                'jjsoft.jjsoft_generator.path.routes', base_path($module.'Http/routes.php'),
                'jjsoft.jjsoft_generator.path.views',base_path($moduleViews)
            ]);
        }

        $this->pathRepository = base_path($module.'Repositories/').$prefix;
        $this->pathModel = base_path($moduleModels).$prefix;
        $this->pathDataTables = base_path($module.'DataTables/').$prefix;
        $this->pathApiController = base_path($module.'Http/Controllers/API/').$prefix;
        $this->pathApiRequest = base_path($module.'Http/Requests/API/').$prefix;
        $this->pathApiRoutes = base_path($module.'Http/api_routes.php');
        $this->pathApiTests = base_path($moduleTests);
        $this->pathApiTestTraits = base_path($moduleTests.'traits/');
        $this->pathController = base_path($module.'Http/Controllers/').$prefix;
        $this->pathRequest = base_path($module.'Http/Requests/').$prefix;
        $this->pathRoutes = base_path($module.'Http/routes.php');
        $this->pathViews = base_path($moduleViews).$viewPrefix.$this->mCamelPlural.'/';
    }

    public function loadDynamicVariables(CommandData &$commandData)
    {
        $commandData->addDynamicVariable('$NAMESPACE_APP$', $this->nsApp);
        $commandData->addDynamicVariable('$NAMESPACE_REPOSITORY$', $this->nsRepository);
        $commandData->addDynamicVariable('$NAMESPACE_MODEL$', $this->nsModel);
        $commandData->addDynamicVariable('$NAMESPACE_DATATABLES$', $this->nsDataTables);
        $commandData->addDynamicVariable('$NAMESPACE_MODEL_EXTEND$', $this->nsModelExtend);

        $commandData->addDynamicVariable('$NAMESPACE_API_CONTROLLER$', $this->nsApiController);
        $commandData->addDynamicVariable('$NAMESPACE_API_REQUEST$', $this->nsApiRequest);

        $commandData->addDynamicVariable('$NAMESPACE_BASE_CONTROLLER$', $this->nsBaseController);
        $commandData->addDynamicVariable('$NAMESPACE_CONTROLLER$', $this->nsController);
        $commandData->addDynamicVariable('$NAMESPACE_REQUEST$', $this->nsRequest);
        $commandData->addDynamicVariable('$NAMESPACE_REQUEST_BASE$', $this->nsRequestBase);

        $this->prepareTableName();

        $commandData->addDynamicVariable('$TABLE_NAME$', $this->tableName);
        
        $commandData->addDynamicVariable('$CONNECTION_NAME$', $this->getOption('connectionName'));
        $commandData->addDynamicVariable('$MODULE_NAME$', $this->getOption('moduleName'));
        $commandData->addDynamicVariable('$MODULE_NAME_LOWER$', Str::lower($this->getOption('moduleName')));

        $commandData->addDynamicVariable('$MODEL_NAME$', $this->mName);
        $commandData->addDynamicVariable('$MODEL_NAME_CAMEL$', $this->mCamel);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL$', $this->mPlural);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL_CAMEL$', $this->mCamelPlural);
        $commandData->addDynamicVariable('$MODEL_NAME_SNAKE$', $this->mSnake);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL_SNAKE$', $this->mSnakePlural);

        if (!empty($this->prefixes['route'])) {
            $commandData->addDynamicVariable('$ROUTE_NAMED_PREFIX$', $this->prefixes['route'].'.');
            $commandData->addDynamicVariable('$ROUTE_PREFIX$', str_replace('.', '/', $this->prefixes['route']).'/');
        } else {
            $commandData->addDynamicVariable('$ROUTE_PREFIX$', '');
            $commandData->addDynamicVariable('$ROUTE_NAMED_PREFIX$', '');
        }

        if (!empty($this->prefixes['ns'])) {
            $commandData->addDynamicVariable('$PATH_PREFIX$', $this->prefixes['ns'].'\\');
        } else {
            $commandData->addDynamicVariable('$PATH_PREFIX$', '');
        }

        if (!empty($this->prefixes['view'])) {
            $commandData->addDynamicVariable('$VIEW_PREFIX$', str_replace('/', '.', $this->prefixes['view']).'.');
        } else {
            $commandData->addDynamicVariable('$VIEW_PREFIX$', '');
        }

        if (!empty($this->prefixes['public'])) {
            $commandData->addDynamicVariable('$PUBLIC_PREFIX$', $this->prefixes['public']);
        } else {
            $commandData->addDynamicVariable('$PUBLIC_PREFIX$', '');
        }

        $commandData->addDynamicVariable(
            '$API_PREFIX$',
            config('jjsoft.jjsoft_generator.api_prefix', 'api')
        );

        $commandData->addDynamicVariable(
            '$API_VERSION$',
            config('jjsoft.jjsoft_generator.api_version', 'v1')
        );

        return $commandData;
    }

    public function prepareTableName()
    {
        if ($this->getOption('tableName')) {
            $this->tableName = $this->getOption('tableName');
        } else {
            $this->tableName = $this->mSnakePlural;
        }
    }

    public function prepareModelNames()
    {
        $this->mPlural = Str::plural($this->mName);
        $this->mCamel = Str::camel($this->mName);
        $this->mCamelPlural = Str::camel($this->mPlural);
        $this->mSnake = Str::snake($this->mName);
        $this->mSnakePlural = Str::snake($this->mPlural);
    }

    public function prepareOptions(CommandData &$commandData, $options = null)
    {
        if (empty($options)) {
            $options = self::$availableOptions;
        }
                
        foreach ($options as $option) {
            $this->options[$option] = $commandData->commandObj->option($option);
        }

        if (isset($options['fromTable']) and $this->options['fromTable']) {
            if (!$this->options['tableName']) {
                $commandData->commandError('tableName required with fromTable option.');
                exit;
            }
        }
    
        $this->options['softDelete'] = config('jjsoft.jjsoft_generator.options.softDelete', false);
        if (!empty($this->options['skip'])) {
            $this->options['skip'] = array_map('trim', explode(',', $this->options['skip']));
        }

        if (!empty($this->options['datatables'])) {
            if (strtolower($this->options['datatables']) == 'true') {
                $this->addOns['datatables'] = true;
            } else {
                $this->addOns['datatables'] = false;
            }
        }
    }

    public function preparePrefixes()
    {
        $this->prefixes['route'] = explode('/', config('jjsoft.jjsoft_generator.prefixes.route', ''));
        $this->prefixes['path'] = explode('/', config('jjsoft.jjsoft_generator.prefixes.path', ''));
        $this->prefixes['view'] = explode('.', config('jjsoft.jjsoft_generator.prefixes.view', ''));
        $this->prefixes['public'] = explode('/', config('jjsoft.jjsoft_generator.prefixes.public', ''));

        if ($this->getOption('prefix')) {
            $multiplePrefixes = explode(',', $this->getOption('prefix'));

            $this->prefixes['route'] = array_merge($this->prefixes['route'], $multiplePrefixes);
            $this->prefixes['path'] = array_merge($this->prefixes['path'], $multiplePrefixes);
            $this->prefixes['view'] = array_merge($this->prefixes['view'], $multiplePrefixes);
            $this->prefixes['public'] = array_merge($this->prefixes['public'], $multiplePrefixes);
        }

        $this->prefixes['route'] = array_diff($this->prefixes['route'], ['']);
        $this->prefixes['path'] = array_diff($this->prefixes['path'], ['']);
        $this->prefixes['view'] = array_diff($this->prefixes['view'], ['']);
        $this->prefixes['public'] = array_diff($this->prefixes['public'], ['']);

        $routePrefix = '';

        foreach ($this->prefixes['route'] as $singlePrefix) {
            $routePrefix .= Str::camel($singlePrefix).'.';
        }

        if (!empty($routePrefix)) {
            $routePrefix = substr($routePrefix, 0, strlen($routePrefix) - 1);
        }

        $this->prefixes['route'] = $routePrefix;

        $nsPrefix = '';

        foreach ($this->prefixes['path'] as $singlePrefix) {
            $nsPrefix .= Str::title($singlePrefix).'\\';
        }

        if (!empty($nsPrefix)) {
            $nsPrefix = substr($nsPrefix, 0, strlen($nsPrefix) - 1);
        }

        $this->prefixes['ns'] = $nsPrefix;

        $pathPrefix = '';

        foreach ($this->prefixes['path'] as $singlePrefix) {
            $pathPrefix .= Str::title($singlePrefix).'/';
        }

        if (!empty($pathPrefix)) {
            $pathPrefix = substr($pathPrefix, 0, strlen($pathPrefix) - 1);
        }

        $this->prefixes['path'] = $pathPrefix;

        $viewPrefix = '';

        foreach ($this->prefixes['view'] as $singlePrefix) {
            $viewPrefix .= Str::camel($singlePrefix).'/';
        }

        if (!empty($viewPrefix)) {
            $viewPrefix = substr($viewPrefix, 0, strlen($viewPrefix) - 1);
        }

        $this->prefixes['view'] = $viewPrefix;

        $publicPrefix = '';

        foreach ($this->prefixes['public'] as $singlePrefix) {
            $publicPrefix .= Str::camel($singlePrefix).'/';
        }

        if (!empty($publicPrefix)) {
            $publicPrefix = substr($publicPrefix, 0, strlen($publicPrefix) - 1);
        }

        $this->prefixes['public'] = $publicPrefix;
    }

    public function overrideOptionsFromJsonFile($jsonData)
    {
        $options = self::$availableOptions;

        foreach ($options as $option) {
            if (isset($jsonData['options'][$option])) {
                $this->setOption($option, $jsonData['options'][$option]);
            }
        }

        $addOns = ['swagger', 'tests', 'datatables'];

        foreach ($addOns as $addOn) {
            if (isset($jsonData['addOns'][$addOn])) {
                $this->addOns[$addOn] = $jsonData['addOns'][$addOn];
            }
        }
    }

    public function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }

        return false;
    }

    public function getAddOn($addOn)
    {
        if (isset($this->addOns[$addOn])) {
            return $this->addOns[$addOn];
        }

        return false;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    public function prepareAddOns()
    {
        $this->addOns['swagger'] = config('jjsoft.jjsoft_generator.add_on.swagger', false);
        $this->addOns['tests'] = config('jjsoft.jjsoft_generator.add_on.tests', false);
        $this->addOns['datatables'] = config('jjsoft.jjsoft_generator.add_on.datatables', false);
        $this->addOns['menu.enabled'] = config('jjsoft.jjsoft_generator.add_on.menu.enabled', false);
        $this->addOns['menu.menu_file'] = config('jjsoft.jjsoft_generator.add_on.menu.menu_file', 'layouts.menu');
    }
}
