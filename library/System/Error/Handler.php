<?php
namespace System\Error;
/**
 * @author xerox
 */
class Handler
{
    public function handle($error)
    {
        print_r($error);
    }
}
