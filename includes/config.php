<?php
// Config file for the Web Service Application
defined('ENVIRONMENT')
    || define('ENVIRONMENT', 'development');

defined('BASE_URL')
    || define('BASE_URL', 'http://localhost/voting/');

defined('DS')
    || define('DS', DIRECTORY_SEPARATOR);

defined('ROOT_PATH')
    || define('ROOT_PATH', realpath(dirname(__FILE__). DS . ".." . DS));

defined('LIB_PATH')
    || define('LIB_PATH', ROOT_PATH . DS . 'libs'. DS);

defined('INCLUDE_PATH')
    || define('INCLUDE_PATH', ROOT_PATH . DS . 'includes'. DS);

defined('LOG_PATH')
    || define('LOG_PATH', ROOT_PATH . DS . 'tmp' . DS . 'logs' . DS);

defined('DB_HOST_SPORTS')
    || define('DB_HOST_SPORTS', 'localhost');

defined('DB_PORT')
    || define('DB_PORT', '');

defined('DB_NAME_SPORTS')
    || define('DB_NAME_SPORTS', 'sports');

defined('DB_USER')
    || define('DB_USER', 'root');

defined('DB_PASSWORD')
    || define('DB_PASSWORD', 'Control123');
##########################################################

defined('DB_HOST_SPORTS')
    || define('DB_HOST_LOCAL', 'localhost');

defined('DB_PORT')
    || define('DB_PORT', '');

defined('DB_NAME_LOCAL')
    || define('DB_NAME_LOCAL', '_app_voting');

defined('DB_USER')
    || define('DB_USER_LOCAL', 'root');

defined('DB_PASSWORD')
    || define('DB_PASSWORD_LOCAL', 'emlinux88');

##########################################################

defined('DB_HOST_TALKSPORT')
    || define('DB_HOST_TALKSPORT', '208.109.186.98');

defined('DB_PORT')
    || define('DB_PORT', '');

defined('DB_NAME_TALKSPORT')
    || define('DB_NAME_TALKSPORT', 'talksport');



defined('DB_HOST_NEWSERVER')
    || define('DB_HOST_NEWSERVER', '5.101.145.3');

defined('DB_PORT')
    || define('DB_PORT', '');

defined('DB_NAME_NEWSERVER')
    || define('DB_NAME_NEWSERVER', 'sports');


defined('DB_DRIVER')
    || define('DB_DRIVER', 'mysql');
?>
