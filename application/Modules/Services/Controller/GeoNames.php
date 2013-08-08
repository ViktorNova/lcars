<?php
namespace Modules\Services\Controller;
/**
 * @author xerox
 */
class GeoNames extends \System\Controller\Action
{
    /**
     * @var \Modules\Services\Vendor\GeoNames\Controller\Api $_service
     */
    protected $_service;

    public function __construct()
    {
        $this->_service = new \Modules\Services\Vendor\GeoNames\Controller\Api();
        parent::__construct(func_get_args());
    }

    public function searchAction()
    {
        $this->_setContentType('application/json');
        $this->_setViewEnabled(true);
        $this->_setViewFileType('.json');

        $params = $this->getParams();
        $searchVars = array(
            'q' => null,
            'name' => null,
            'name_equals' => null,
            'startRow' => null,
            'maxRows' => null,
            'featureClass' => null,
            'featureCode' => null,
            'orderby' => null
        );

        $filter = array();
        foreach ($params as $key => $param) {
            if (array_key_exists($key, $searchVars)) {
                $filter[$key] = urlencode($param);
            }
        }

        if (!empty($filter['q']) || !empty($filter['name']) || !empty($filter['name_equals'])) {
            $result = $this->_service->search($filter);

            $this->setModel(new \Modules\Services\Model\GeoNamesData());

            $this->_model->data = json_encode($result);
        }
        else {
            header('HTTP/1.0 404 Not Found');
            throw new \Exception('missing search param');
        }

    }

    public function listFilterAction()
    {
        $this->_setContentType('application/json');
        $this->_setViewEnabled(true);
        $this->_setViewFileType('.json');

        $result = $this->_service->listFilter();

        $this->setModel(new \Modules\Services\Model\GeoNamesData());

        $this->_model->data = json_encode($result);
    }
}
