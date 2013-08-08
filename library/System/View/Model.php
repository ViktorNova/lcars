<?php
namespace System\View;
/**
 * @author xerox
 */
class Model extends \System\Model\Base
{
    /**
     * @var string $_content
     */
    protected $_content;

    /**
     * @var array $_data
     */
    protected $_data;

    /**
     * render view
     */
    public function render()
    {
        $data = !empty($this->_data) ? $this->_data : array();
        preg_match_all('/({{[\w]+}})/', $this->_content, $vars);
        foreach ($vars[1] as $key => $var)
        {
            $vars[1][$key] = '/' . $var . '/';
        }

        foreach ($data as $key => $value)
        {
            foreach ($vars[1] as $var)
            {
                $placeholderKey = preg_replace('/\/{{([\w]+)}}\//', '$1', $var);
                if ($placeholderKey == $key)
                {
                    $this->_content = preg_replace($var, $value,
                        $this->_content);
                }
            }
        }

        echo $this->_content;
    }
}
