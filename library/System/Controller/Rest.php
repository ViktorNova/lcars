<?php
namespace System\Controller;
/**
 * @author xerox
 * @abstract
 */
abstract class Rest extends \System\Controller\Index
{
    const DEFAULT_REST_METHOD = 'GET';

    public function indexAction()
    {
        $httpRequestMethod = self::DEFAULT_REST_METHOD;
        if (isset($_SERVER['REQUEST_METHOD']))
        {
            $httpRequestMethod = $_SERVER['REQUEST_METHOD'];
        }
        $requestType = strtolower($httpRequestMethod);
        $requestAction = $requestType . $this->_actionSuffix;
        $this->_action = $requestType;
        $this->$requestAction();
    }

    public function getAction()
    {
    }

    public function postAction()
    {

    }

    public function putAction()
    {

    }

    public function deleteAction()
    {

    }
}
