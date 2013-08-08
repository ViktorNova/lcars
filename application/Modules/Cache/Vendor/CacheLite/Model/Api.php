<?php
namespace Modules\Cache\Vendor\CacheLite\Model;
/**
 * @author xerox
 * @final
 */
final class Api
{
    /**
     * @var \Cache_Lite $_service
     */
    private $_service;

    /**
     * @param \Cache_Lite $service
     */
    public function __construct(\Cache_Lite $service)
    {
        $this->_service = $service;
    }

    /**
     * @see \Cache_Lite::get()
     * @param string $id
     * @return mixed
     */
    public function get($id = null)
    {
        $data = $this->_service->get($id);
        return $data;
    }

    /**
     * @see \Cache_Lite::save()
     * @param mixed $data
     * @param string $id
     * @return boolean
     */
    public function save($data = null, $id = null)
    {
        return $this->_service->save($data, $id);
    }
}
