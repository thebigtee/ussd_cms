<?php
require_once('config.php');
require_once(LIB_PATH . 'Exception.class.php');
require_once(LIB_PATH . 'Database.class.php');
require_once(LIB_PATH . 'Logger.class.php');

$baseLogger = new Logger(LOG_PATH . 'error.log');
$db_local = New Database();
$db_local->set_variables(DB_DRIVER, DB_HOST_LOCAL, DB_NAME_LOCAL, DB_USER_LOCAL, DB_PASSWORD_LOCAL);

// $db_local = New Database();
// $db_local->set_variables(DB_DRIVER, DB_HOST_SPORTS, DB_NAME_SPORTS, DB_USER, DB_PASSWORD);
//
// $db_98_talksport = New Database();
// $db_98_talksport->set_variables(DB_DRIVER, DB_HOST_TALKSPORT, DB_NAME_TALKSPORT, DB_USER, DB_PASSWORD);
//
// $db_98_newserver = New Database();
// $db_98_newserver->set_variables(DB_DRIVER, DB_HOST_NEWSERVER, DB_NAME_NEWSERVER, DB_USER, DB_PASSWORD);


// if((!$db_86) || (!$db_98_talksport) || (!$db_98_newserver))
// 	$baseLogger->log("Database Connection Not Available", Logger::FATAL);
if(!$db_86){
		$baseLogger->log("Database Connection Not Available", Logger::FATAL);
}

?>
