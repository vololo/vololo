<?php

defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', realpath(dirname(__FILE__)));

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', PUBLIC_PATH . '/../application');

defined('DATA_PATH')
    || define('DATA_PATH', PUBLIC_PATH . '/../data');

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

defined('CACHE_DIR')
    || define('CACHE_DIR', 'c');

defined('VOLOLO_DIR')
    || define('VOLOLO_DIR', 'g');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Application.php';
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()->run();
