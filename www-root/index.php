<?php
ini_set('display_errors', 1);

// Define the application path
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

define('DOCTRINE_PATH', realpath(dirname(__FILE__) . '/../lib/doctrine2/lib'));
define('ZEND_PATH', realpath(dirname(__FILE__) . '/../lib/zf2/library'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH),
    ZEND_PATH,
    get_include_path(),
)));

require_once 'Zend/Application/Application.php';

use Zend\Application\Application;

$application = new Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()->run();
