<?php
namespace System\Model;
/**
 * @author xerox
 * @abstract
 */
abstract class Base
{
    /**
     * @param mixed $key
     */
    public function __get($key)
    {
        $key = '_' . $key;
        return $this->$key;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $key = '_' . $key;
        $this->$key = $value;
    }

    /**
     * @param boolean $withEmtpyFields
     * @return array
     */
    public function toArray($withEmtpyFields = true)
    {
        $vars = get_object_vars($this);
        $returnVars = array();
        foreach ($vars as $key => $var)
        {
            $key = preg_replace('/^_/', '', $key);

            if ($withEmtpyFields || !(empty($var) || is_null($var)))
            {
                $returnVars[$key] = $var;
            }
        }
        return $returnVars;
    }
}
