<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public $frontController = null;

	protected function _initRequest(array $options = array())
	{
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $request->setBaseUrl('/');
        $front->setRequest($request);
        return $request;
	}

	public function run (){
		$this->setupEnvironment();
		$this->prepare ();
		$this->init();
		$this->_initNavigation ();
		$response = $this->frontController->dispatch();
        $this->sendResponse($response);
	}

	public function setupEnvironment()
    {
		error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', true);
	}

	public function prepare()
    {
        $this->setupFrontController();
        $this->setupView();
		Zend_Layout::startMvc(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'scripts');
	}

	protected function init (){
		Zend_Session::start();
		Koala_Core_Init::initConfiguration();
		$configuration =  Koala_Core_Configuration::getConfig();
		Zend_Registry::set('config', $configuration);
	}

	protected function _initNavigation () {
		$configNavigation = new Zend_Config_Xml(CONFIG_PATH . DIRECTORY_SEPARATOR . 'navigation.xml', 'nav');
		Zend_Registry::set('configNavigation', $configNavigation);
		$navigation = new Zend_Navigation($configNavigation);
		Zend_Registry::set('Zend_Navigation', $navigation);
	}

	public function sendResponse(Zend_Controller_Response_Http $response)
    {
        $response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
        $response->sendResponse();
	}

	protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
	}

	public function setupView()
    {
        $view = new Zend_View();
		$view->setEncoding('UTF-8');
	}

	public function setupFrontController()
    {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->setFallbackAutoloader(true);
        $this->frontController = Zend_Controller_Front::getInstance();
        $this->frontController->returnResponse(true);
        $this->frontController->setControllerDirectory
		(
            APPLICATION_PATH . DIRECTORY_SEPARATOR . 'controllers'
        );
		$this->frontController->addModuleDirectory(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR, 'modules');
	}

}
