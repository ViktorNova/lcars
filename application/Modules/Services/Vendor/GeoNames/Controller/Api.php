<?php
namespace Modules\Services\Vendor\GeoNames\Controller;
use \Modules\Cache\Vendor\CacheLite\Controller\Api as Cache;
/**
 * @author xerox
 * @final
 */
final class Api
{
    /**
     * @var \Modules\Services\Vendor\GeoNames\Model\Api $_model
     */
    private $_model;

    public function __construct()
    {
        require_once PHP_PEAR_PATH . 'Services/GeoNames.php';
        if (class_exists('\Services_GeoNames'))
        {
            if (class_exists('\Modules\Cache\Vendor\CacheLite\Controller\Api'))
            {
                $this->_model = new \Modules\Services\Vendor\GeoNames\Model\Api(
                    new \Services_GeoNames(), new Cache());
            }
            else
            {
                throw new \Exception(
                    'Class "\Modules\Cache\Vendor\CacheLite\Controller\Api" not exists');
            }
        }
        else
        {
            throw new \Exception('Class "\Services_GeoNames" not exists');
        }
    }

    /**
     * @param array $filter
     * @return \Modules\Services\Vendor\GeoNames\Model\Api::search()[]
     */
    public function search(array $filter = array())
    {
        return $this->_model->search($filter);
    }

    /**
     * @return \Modules\Services\Vendor\GeoNames\Model\Api::getSupportedEndpoints()[]
     */
    public function listFilter()
    {
        return $this->_model->listFilter();
    }
}
