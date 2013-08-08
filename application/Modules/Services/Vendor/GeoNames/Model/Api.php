<?php
namespace Modules\Services\Vendor\GeoNames\Model;
use \Modules\Cache\Vendor\CacheLite\Controller\Api as Cache;
use \Modules\Cache\Vendor\CacheLite\Model\Api as CacheModel;
/**
 * @author xerox
 * @final
 */
final class Api
{
    /**
     * @var CacheModel $_cache
     */
    private $_cache;

    /**
     * @var \Services_GeoNames $_service
     */
    private $_service;

    /**
     * @var string $type
     */
    public $type = 'json';

    /**
     * @var string $style
     */
    public $style = 'FULL';

    /**
     * @var int $startRow
     */
    public $startRow = 0;

    /**
     * @var int $maxRows
     */
    public $maxRows = 10;

    /**
     * @param \Services_GeoNames $service
     * @param Cache $cache
     */
    public function __construct(\Services_GeoNames $service, Cache $cache)
    {
        $this->_service = $service;
        $this->_cache = $cache->getModel();
    }

    /**
     * @see \Services_GeoNames::search()
     * @param array $filter
     * @return array [array $filter, \Services_GeoNames::search()[]]
     */
    public function search(array $filter = array())
    {
        $cacheKey = get_called_class() . '::search::'
            . base64_encode((serialize($filter)));
        $filter = $this->_getFilter($filter);
        if ($data = $this->_cache->get($cacheKey))
        {
            if ($data['filter'] == $filter)
            {
                header('X-Cache-Lite: hit');
                return $data;
            }
        }
        $data = array(
            'filter' => $filter, 'data' => $this->_service->search($filter)
        );
        $this->_cache->save($data, $cacheKey);
        header('X-Cache-Lite: miss');
        return $data;
    }

    /**
     * @see \Services_GeoNames::getSupportedEndpoints()
     * @return \Services_GeoNames::getSupportedEndpoints()[]
     */
    public function listFilter()
    {
        $cacheKey = get_called_class() . '::listFilter';
        if ($data = $this->_cache->get($cacheKey))
        {
            header('X-Cache-Lite: hit');
            return $data;
        }
        $data = $this->_service->getSupportedEndpoints();
        $this->_cache->save($data, $cacheKey);
        header('X-Cache-Lite: miss');
        return $data;
    }

    /**
     * @param array $filter
     * @return array
     */
    private function _getFilter(array $filter)
    {
        $defaultFilter = array(
            'type' => $this->type, 'style' => $this->style,
            'startRow' => $this->startRow, 'maxRows' => $this->maxRows
        );
        return array_merge($defaultFilter, $filter);
    }
}
