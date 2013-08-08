<?php
namespace System\Controller;
/**
 * @author xerox
 */
class Action extends \System\Controller\Rest
{
    /**
     * @param array | array[0] [\System\Router\Route, \System\Module\Model]
     */
    public function __construct()
    {
        $args = func_get_args();
        $args = !is_object($args[0]) ? $args[0] : $args;
        $this->_route = $args[0];
        $this->_module = $args[1];
        parent::__construct($this->_route, $this->_module);
    }

    /**
     * @throws \Exception
     * @return \System\Controller\Action
     */
    public function init()
    {
        try
        {
            /*
             * get module action screen
             */
            if (class_exists($this->_controller))
            {
                return $this->_moduleControllerAction();
            } /*
               * get module action index screen
               */
            else if (class_exists(
                $this->_controller . $this->_controllerDefault))
            {
                return $this->_moduleControllerDefaultAction();
            } /*
               * get module default action index screen
               */
            else if ($this->_module->getNamespace()
                == '\\' . $this->_modulePath . '\\')
            {
                return $this->_moduleDefaultControllerDefaultAction();
            }
            header('HTTP/1.0 404 Not Found');
            throw new \Exception(
                'Controller class "' . $this->_controller
                    . ((empty($this->_controllerName))
                        ? $this->_controllerDefault
                        : '') . '" not defined');
        }
        catch (\Exception $error)
        {
            $this->_errorHandler->handle($error);
        }
    }

    /**
     * @throws \Exception
     * @return \System\Controller\Action
     */
    private function _moduleControllerAction()
    {
        /* @var $controller \System\Controller\Action */
        $controller = new $this->_controller($this->_route, $this->_module);
        $action = $this->_action;
        /*
         * call controller action
         */
        if (method_exists($controller, $action))
        {
            if ($action == ($this->_actionDefault . $this->_actionSuffix))
            {
                header('HTTP/1.0 301 Moved Permanently');
                header(
                    'Location: ' . $this->_route->getProtocol() . '://'
                        . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '/'
                        . strtolower(
                            preg_replace(
                                '/\\\\' . $this->_modulePath . '\\\/', '',
                                $this->_module->getNamespace() . '/'
                                    . $this->_controllerName)));
            }

            $controller->$action($this->_params);
            $controller->registerView();
            $this->_view = $controller->getView();
            if (method_exists($this->_view, 'render'))
            {
                $this->_view->render();
            }
            return $controller;
        } /*
           * call controller index action
           */
        else if (empty($action))
        {
            $action = strtolower($this->_actionDefault) . $this->_actionSuffix;
            $controller->$action($this->_params);
            $controller->registerView();
            $this->_view = $controller->getView();
            if (method_exists($this->_view, 'render'))
            {
                $this->_view->render();
            }
            return $controller;
        }
        header('HTTP/1.0 404 Not Found');
        throw new \Exception(
            'Controller action method "' . $action . '()" not defined');
    }

    /**
     * @return \System\Controller\Action
     */
    private function _moduleControllerDefaultAction()
    {
        /* @var $controller \System\Controller\Action */
        $controllerClass = $this->_controller . $this->_controllerDefault;
        $action = strtolower($this->_actionDefault) . $this->_actionSuffix;
        $controller = new $controllerClass($this->_route, $this->_module);
        $controller->$action($this->_params);
        $controller->registerView();
        $this->_view = $controller->getView();
        if (method_exists($this->_view, 'render'))
        {
            $this->_view->render();
        }
        return $controller;
    }

    /**
     * @return \System\Controller\Action
     */
    private function _moduleDefaultControllerDefaultAction()
    {
        /* @var $controller \System\Controller\Action */
        $controllerClass = $this->_module->getNamespace()
            . $this->_moduleDefault . '\\' . $this->_controllerPath . '\\'
            . $this->_controllerDefault;
        $action = $this->_actionDefault . $this->_actionSuffix;
        $controller = new $controllerClass($this->_route, $this->_module);
        $controller->$action($this->_params);
        $controller->registerView();
        $this->_view = $controller->getView();
        if (method_exists($this->_view, 'render'))
        {
            $this->_view->render();
        }
        return $controller;
    }
}
