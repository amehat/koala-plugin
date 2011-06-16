<?php
if ( !defined('ROOT_PATH') ){
	define ('ROOT_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' ));
}

if ( !defined('APPLICATION_PATH') ){
	define ('APPLICATION_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'application'));
}

if ( !defined ('CONFIG_PATH') ){
	define ('CONFIG_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs'));
}
 
if ( !defined('LIBRARY_PATH') ){
	define('LIBRARY_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'library'));
}

if ( !defined ('PLUGIN_PATH') ){
	define ('PLUGIN_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'plugin'));
}

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

set_include_path(implode(PATH_SEPARATOR, array(
		realpath(APPLICATION_PATH . '/../library'),
		get_include_path(),
	)));
 
require_once LIBRARY_PATH . DIRECTORY_SEPARATOR . 'Zend/Application.php';
$application = new Zend_Application(
		APPLICATION_ENV,
		CONFIG_PATH . DIRECTORY_SEPARATOR . 'application.ini'
);
$application->bootstrap ()->run();
