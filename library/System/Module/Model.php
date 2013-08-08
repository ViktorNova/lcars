<?php
namespace System\Module;
/**
 * @author xerox
 */
class Model
{
    /**
     * @var \System\Router\Route::get[]
     */
    protected $_route;

    /**
     * @var string $_moduleNamespace
     * @static
     */
    protected static $_moduleNamespace;

    /**
     * @var string $_moduleName
     * @static
     */
    protected static $_moduleName;

    /**
     * @var string $_modulePath
     */
    protected $_modulePath;

    /**
     * @param \System\Router\Route $route
     */
    public function __construct(\System\Router\Route $route)
    {
        $this->_route = $route;
        $this->_modulePath = 'Modules';
    }

    public function fetch()
    {
        $this->_getModuleName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::$_moduleName;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return self::$_moduleNamespace;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function _getModuleName()
    {
        self::$_moduleName = $this->_route->getModule();
        self::$_moduleNamespace = '\\' . $this->_modulePath . '\\'
            . self::$_moduleName;

        $modulePath = \APPLICATION_PATH
            . preg_replace('/\\\/', '/', self::$_moduleNamespace);

        try
        {
            if (is_dir($modulePath))
            {
                return;
            }
            throw new \Exception(
                'Module in namespace "' . self::$_moduleNamespace
                    . '" not defined');
        }
        catch (\Exception $error)
        {
            print_r($error);
            exit;
        }
    }
}
