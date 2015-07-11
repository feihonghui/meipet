<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

define('DOC_ROOT', dirname(__FILE__));
define('APP_PATH','./upload/');
define('APP_DEBUG',True);
require './ThinkPHP/ThinkPHP.php';
?>