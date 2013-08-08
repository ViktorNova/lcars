<?php
namespace System\Boot;
/**
 * @author xerox
 * @abstract
 */
abstract class Run
{
    /**
     * @var \System\Router\Route $_route
     */
    protected $_route;

    /**
     * @var \System\Module\Model $_module
     */
    protected $_module;

    /**
     * @var \System\Controller\Action $_controller
     */
    protected $_controller;

    public function __construct()
    {
        $this->_initRoute();
        $this->_initModule();
        $this->_initController();
    }

    protected function _initRoute()
    {
        $this->_route = new \System\Router\Route();
        $this->_route->fetch();
    }

    protected function _initModule()
    {
        $this->_module = new \System\Module\Model($this->_route);
        $this->_module->fetch();
    }

    protected function _initController()
    {
        $this->_controller = new \System\Controller\Action($this->_route,
            $this->_module);
        $this->_controller->init();
    }
}
