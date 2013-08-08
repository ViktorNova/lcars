<?php
namespace Modules\Test\Controller;
/**
 * @author xerox
 */
class ExtJs extends \System\Controller\Action
{
    public function getAction()
    {
        $this->_setContentType('application/json');
        $this->_setViewEnabled(true);
        $this->_setViewFileType('.json');

        $this->setModel(new \Modules\Test\Model\ExtJs());

        $data = array(
            array(
                "id" => 1, "name" => "test"
            ),
            array(
                "id" => 2, "name" => "test"
            )
        );

        //$data = array();

        if (is_array($data) && count($data) > 0)
        {
            $frontendModel = $this->_model->extJsCreateFrontendModel();
            $this->_model->extJsSetDataFields(true, $data, 'done', $frontendModel);
        }
        else
        {
            $this->_model->extJsSetDataFields(false);
        }
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
