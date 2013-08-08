<?php
namespace Modules\Cache\Vendor\CacheLite\Controller;
/**
 * @author xerox
 * @final
 */
final class Api
{
    /**
     * @var \Modules\Cache\Vendor\CacheLite\Model\Api $_model
     */
    private $_model;

    /**
     * @var \Cache_Lite $_service
     */
    private $_service;

    public function __construct()
    {
        require_once PHP_PEAR_PATH . 'Cache/Lite.php';
        if (class_exists('\Cache_Lite'))
        {
            $this->_model = new \Modules\Cache\Vendor\CacheLite\Model\Api(
                new \Cache_Lite(
                    array(
                        'cacheDir' => \LIBRARY_PATH . '/Temp/',
                        'automaticSerialization' => true, 'lifeTime' => 3600
                    )));
        }
        else
        {
            throw new \Exception('Class "\Cache_Lite" not exists');
        }
    }

    /**
     * @return \Modules\Cache\Vendor\CacheLite\Model\Api
     */
    public function getModel()
    {
        return $this->_model;
    }
}
