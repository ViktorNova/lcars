<?php
namespace System\Router;
/**
 * @author xerox
 */
class Route
{
    /**
     * @var array $_route
     * @static
     */
    protected static $_route = array();

    /**
     * @var string $_defaultContentType
     */
    protected $_defaultContentType;

    public function __construct()
    {
        $this->_defaultContentType = 'text/plain';
        $this->setContentType();
    }

    public function fetch()
    {
        self::$_route['path'] = $this->_getPathInfo();
    }

    /**
     * @return array
     */
    public function get()
    {
        return self::$_route;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        $isSecure = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
        {
            $isSecure = true;
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
            && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
            || !empty($_SERVER['HTTP_X_FORWARDED_SSL'])
                && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
        {
            $isSecure = true;
        }
        return $isSecure ? 'https' : 'http';
    }

    /**
     * @return string
     */
    public function getModule()
    {
        $route = $this->get();
        /*
         * return module parameter
         */
        return $this->_getParameterName((string) array_shift($route['path']));
    }

    /**
     * @param boolean $withHyphen
     * @return string
     */
    public function getController($withHyphen = false)
    {
        $route = $this->get();
        /*
         * shift module parameter
         */
        array_shift($route['path']);
        /*
         * return controller parameter
         */
        return $this
            ->_getParameterName((string) array_shift($route['path']),
                $withHyphen);
    }

    /**
     * @param boolean $withHyphen
     * @return string
     */
    public function getAction($withHyphen = false)
    {
        $route = $this->get();
        /*
         * shift module and controller parameter
         */
        array_shift($route['path']);
        array_shift($route['path']);
        /*
         * return action parameter
         */
        return $this
            ->_getParameterName((string) array_shift($route['path']),
                $withHyphen);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $route = $this->get();

        /*
         * shift module, controller and action parameter
         */
        array_shift($route['path']);
        array_shift($route['path']);
        array_shift($route['path']);

        /*
         * get remains as params
         */
        $params = $route['path'];

        /*
         * get php input stream
         */
        $inputStream = file_get_contents('php://input');

        /*
         * merge http get param
         */
        if (isset($_GET))
        {
            $params = array_merge($params, $_GET);
        }

        /*
         * merge http post param
         */
        if (isset($_POST))
        {
            $params = array_merge($params, $_POST);
        }

        /*
         * merge input stream
         */
        if (strlen($inputStream) > 0)
        {
            $params = array_merge($params,
                array(
                    'inputStream' => $inputStream
                ));
        }

        /*
         * return parameters
         */
        return $params;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType = '')
    {
        if (empty($contentType))
        {
            $contentType = $this->_defaultContentType;
        }
        header('Content-Type: ' . $contentType);
    }

    /**
     * @return array
     */
    private function _getPathInfo()
    {
        $pathInfo = $this->_probePathInfo();
        return array_filter(preg_split('/\//', $pathInfo));
    }

    /**
     * @return string
     */
    private function _probePathInfo()
    {
        $pathInfo = ((empty($_SERVER['PATH_INFO']))
            ? '/'
            : $_SERVER['PATH_INFO']);

        /*
         * on trailing slash found
         */
        if (strlen(strrchr($_SERVER['REQUEST_URI'], '/')) == 1)
        {
            header('HTTP/1.0 301 Moved Permanently');
            header(
                'Location: ' . $this->getProtocol() . '://'
                    . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']
                    . substr($pathInfo, 0, strlen($pathInfo) - 1));
        }

        return $pathInfo;
    }

    /**
     * @param array $parameterName
     * @param boolean $withHyphen
     * @return string
     */
    private function _getParameterName($parameterName, $withHyphen = false)
    {
        $parameterName = preg_split('/\-+/', $parameterName);
        $parameterName = array_filter($parameterName);
        array_walk($parameterName,
            function (&$value, $key)
            {
                $value = ucfirst($value);
            });
        return join($withHyphen ? '-' : '', $parameterName);
    }
}
