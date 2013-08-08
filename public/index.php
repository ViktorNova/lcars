<?php
/*
 * @author xerox
 */
ob_start();

/*
 * set environment
 */
require_once 'env.php';

/*
 * boot system
 */
new \Core\System\Boot();

ob_end_flush();