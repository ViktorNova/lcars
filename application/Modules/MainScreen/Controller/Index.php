<?php
namespace Modules\MainScreen\Controller;
/**
 * @author xerox
 */
class Index extends \System\Controller\Action
{
    public function indexAction()
    {
        $this->_setContentType('text/html');
        $this->_setViewEnabled(true);
    }
}
