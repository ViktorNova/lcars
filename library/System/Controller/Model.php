<?php
namespace System\Controller;
/**
 * @author xerox
 * @abstract
 */
abstract class Model extends \System\Controller\Base
{
    /**
     * @var \System\Model\Base $_model
     */
    protected $_model;

    /**
     * @return \System\Model\Base
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param \System\Model\Base $model
     */
    public function setModel(\System\Model\Base $model)
    {
        $this->_model = $model;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_model->toArray();
    }
}
