<?php
class Koala_Core_Init {

	protected static $_isInitConfiguration  = false;
    protected static $_isInitDatabase       = false;
    protected static $_isInitEnv            = false;
    protected static $_isInitLog            = false;
    protected static $_isInitPaths          = false;
    protected static $_isInitZendLoader     = false;
	protected static $_instance             = null;

	/**
     * Constructeur non public car
     * doit etre statique
     */
    protected function __construct ()
    {
        self::init();
    }


    /**
     * Cree et retourne une instance d'Koala_Core_Init
     *
     * @return  Koala_Core_Init
     */
    public static function getInstance ()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
	}

	public static function initAll ()
    {
		self::initConfiguration();
        //self::initDatabase();
        self::initEnv();
        //self::initLog();
        self::initPaths();
        self::initZendLoader();
	}

	/**
     * Initialisation de la configuration
     *
     * @return void
     */
    public static function initConfiguration ()
    {
        if (false === self::$_isInitConfiguration) {
            self::initZendLoader();
            self::initEnv();
            Koala_Core_Configuration::init();
            self::$_isInitConfiguration = true;
        }
	}

	/**
     * Definition des variables pour identifier
     * l'environnement.
     *
     * @return  void
     */
    public static function initEnv ()
    {
        if (false === self::$_isInitEnv) {
            defined('APPLICATION_ENV')
                or define('APPLICATION_ENV', (false !== getenv('APPLICATION_ENV')) ? getenv('APPLICATION_ENV') : 'production');
            self::$_isInitEnv = true;
        }
	}

	/**
     * Definition des chemins utilises dans
     * l'application
     *
     * @return  void
     */
    public static function initPaths ()
    {
        if (false === self::$_isInitPaths) {
            defined('APPLICATION_PATH')
                or define('APPLICATION_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'));
            defined('CONFIGS_PATH')
                or define('CONFIGS_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs');
			/*
			defined('LIBRARY_PATH')
                or define('LIBRARY_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'library');
            defined('VENDORS_PATH')
                or define('VENDORS_PATH', LIBRARY_PATH . DIRECTORY_SEPARATOR . 'vendors');
			 */
            set_include_path(
                APPLICATION_PATH
                /*. PATH_SEPARATOR . LIBRARY_PATH
                . PATH_SEPARATOR . VENDORS_PATH
				. PATH_SEPARATOR . APPLICATION_PATH . DIRECTORY_SEPARATOR . 'helpers'*/
                . PATH_SEPARATOR . get_include_path()
            );

            self::$_isInitPaths = true;
        }
    }


	public static function initZendLoader ()
    {
        if (false === self::$_isInitZendLoader) {
            // dependance : pour le require, il
            // faut que l'include_path soit defini
            self::initPaths();
            //Zend_Loader::registerAutoload();
            self::$_isInitZendLoader = true;
        }
    }
}
