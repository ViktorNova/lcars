<?php
namespace Modules\Test\Controller;
/**
 * @author xerox
 */
class Test extends \System\Controller\Action
{
    public function indexAction()
    {
        $this->_setContentType('text/html');
        $this->_setViewEnabled(true);
    }

    public function urlAction()
    {
        $this->_setContentType('application/json');
        $this->_setViewEnabled(true);
        $this->_setViewFileType('.json');

        $this->setModel(new \Modules\Test\Model\Test());

        $this->_model
            ->key = 1;
        $this->_model
            ->value = json_encode(
            array(
                array(
                    'key-a' => 'value-a'
                ),
                array(
                    'key-b' => 'value-b'
                )
            ));
    }
}
