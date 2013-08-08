<?php
namespace System\Controller;
/**
 * @author xerox
 * @abstract
 */
abstract class Base
{
    /**
     * @var \System\Error\Handler $_errorHandler
     */
    protected $_errorHandler;

    /**
     * @var \System\Router\Route $_route
     */
    protected $_route;

    /**
     * @var \System\Module\Model $_module
     */
    protected $_module;

    /**
     * @var string $_moduleDefault
     */
    protected $_moduleDefault;

    /**
     * @var string $_controller
     */
    protected $_controller;

    /**
     * @var string $_controllerName
     */
    protected $_controllerName;

    /**
     * @var string $_controllerPath
     */
    protected $_controllerPath;

    /**
     * @var string $_controllerDefault
     */
    protected $_controllerDefault;

    /**
     * @var string $_action
     */
    protected $_action;

    /**
     * @var string $_actionDefault
     */
    protected $_actionDefault;

    /**
     * @var string $_actionSuffix
     */
    protected $_actionSuffix;

    /**
     * @var array $_params
     */
    protected $_params;

    /**
     * @var \System\View\Model $_view
     */
    protected $_view;

    /**
     * @var string $_viewPath
     */
    protected $_viewPath;

    /**
     * @var boolean $_viewEnabled
     */
    protected $_viewEnabled;

    /**
     * @var string $_viewFileType
     */
    protected $_viewFileType;

    /**
     * @var string $_contentType
     */
    protected $_contentType;

    /**
     * @param \System\Router\Route $route
     * @param \System\Module\Model $module
     */
    public function __construct(\System\Router\Route $route,
        \System\Module\Model $module)
    {
        $this->_modulePath = 'Modules';
        $this->_moduleDefault = 'MainScreen';
        $this->_controllerPath = 'Controller';
        $this->_controllerDefault = 'Index';
        $this->_actionDefault = 'index';
        $this->_actionSuffix = 'Action';
        $this->_viewPath = 'View';
        $this->_viewFileType = '.html';
        $this->_setRouteModel($route);
        $this->_setModuleModel($module);
        $this->_setErrorHandler(new \System\Error\Handler());
        $this->_setViewModel(new \System\View\Model());
        $this->_setViewEnabled();
        $this->_setViewFileType();
        $this->_setContentType('text/plain');
        $this->_setControllerAction();
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param \System\Error\Handler $errorHandler
     */
    private function _setErrorHandler(\System\Error\Handler $errorHandler)
    {
        $this->_errorHandler = $errorHandler;
    }

    /**
     * @param \System\Router\Route $routeModel
     */
    private function _setRouteModel(\System\Router\Route $routeModel)
    {
        $this->_route = $routeModel;
    }

    /**
     * @param \System\Module\Model $moduleModel
     */
    private function _setModuleModel(\System\Module\Model $moduleModel)
    {
        $this->_module = $moduleModel;
    }

    /**
     * @param \System\View\Model $viewModel
     */
    private function _setViewModel(\System\View\Model $viewModel)
    {
        $this->_view = $viewModel;
    }

    /**
     * set controller action
     */
    private function _setControllerAction()
    {
        $moduleNamespace = $this->_module->getNamespace();
        $controller = $this->_route->getController();
        $action = $this->_route->getAction();
        $params = $this->_route->getParams();

        /*
         * set controller class path and name
         */
        $this->_controllerName = $controller;
        $this->_controller = $moduleNamespace . '\\' . $this->_controllerPath
            . '\\' . $this->_controllerName;

        /*
         * set action name
         */
        $this->_action = !empty($action)
            ? lcfirst($action) . $this->_actionSuffix
            : '';

        /*
         * set params
         */
        $this->_params = $params;
    }

    /**
     * @param boolean $boolean
     */
    protected function _setViewEnabled($boolean = false)
    {
        $this->_viewEnabled = $boolean;
    }

    /**
     * @param string $fileType
     */
    protected function _setViewFileType($fileType = '')
    {
        if (empty($fileType))
        {
            $fileType = $this->_viewFileType;
        }
        $this->_viewFileType = $fileType;
    }

    /**
     * @param string $contentType
     */
    protected function _setContentType($contentType = '')
    {
        $this->_route->setContentType($contentType);
    }
}
