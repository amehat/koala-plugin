<?php
class Koala_Core_Configuration {
	
	protected static $_instance = null;
    protected static $_isInit   = false;
    protected static $_config   = null;


    /**
     * Constructeur non public car
     * doit etre statique
     */
    protected function __construct ()
    {
        // chargement du Zend_Loader si pas
        // deja fait
        Koala_Core_Init::initAll();
        self::init();
	}

	/**
     * Regarde si dans la configuration un index "define"
     * est defini. Si c'est le cas, alors pour chaque entree, converti
     * la clef (en camelCase) en majuscules avec underscore
     * et definit ainsi la constante avec la valeur passe.
     *
     * Ainsi si dans le fichier de configuration ".ini" on a :
     *  define.maVariable = "valeur de la variable"
     *
     * Cela va aboutir a cet appel :
     *  define('MA_VARIABLE', 'valeur de la varialbe'
     *
     *  @return void
     */
    protected static function _doDefines ()
    {
        if (self::$_config instanceof Zend_Config_Ini && isset(self::$_config->define)) {
            $defines = self::$_config->define->toArray();
            $filter = new Zend_Filter_Word_CamelCaseToUnderscore();
            while (list($name, $value) = each($defines)) {
                define(strtoupper($filter->filter($name)), $value);
            }
            unset(self::$_config->define);
        }
	}

	/**
     * Retourne la configuration.
     * L'initialise si pas encore fait
     *
     * @return  Zend_Config_Ini|null
     */
    public static function getConfig ()
    {
        self::init();
        return self::$_config;
    }

	/**
     * Cree et retourne une instance de Koala_Core_Configuration
     *
     * @return  Koala_Core_Configuration
     */
    public static function getInstance ()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
	}

	/**
     * Initialise la configuration en allant chercher
     * dans le repertoire
     *
     * @return void
     */
    public static function init ()
    {
        if (false === self::$_isInit) {
            Koala_Core_Init::initPaths();
            self::setConfig(CONFIGS_PATH . DIRECTORY_SEPARATOR . 'application.ini');
            self::$_isInit = true;
        }
	}

	/**
     * Si un fichier de configuration local est
     * defini pour l'environnement alors on l'utilise
     * pour fusionner la configuration
     *
     * @return  void
     */
    protected static function _mergeWithLocal ()
    {
        $localCommonConfigFile = CONFIGS_PATH . DIRECTORY_SEPARATOR
                               . 'local.common.ini';
        if (Zend_Loader::isReadable($localCommonConfigFile)) {
            $localCommonConfig = new Zend_Config_Ini($localCommonConfigFile);
            self::$_config->merge($localCommonConfig);
        }
        if (    isset(self::$_config->define->localConfigsPath)
            &&  !empty(self::$_config->define->localConfigsPath)
            &&  file_exists(self::$_config->define->localConfigsPath)
        ) {
            $directory = self::$_config->define->localConfigsPath;
        }
        else {
            $directory = CONFIGS_PATH;
		}
		/*
        $localConfigFile = $directory . DIRECTORY_SEPARATOR
                         . 'local.' . APPLICATION_DOMAIN . '.ini';
        if (Zend_Loader::isReadable($localConfigFile)) {
            $localConfig = new Zend_Config_Ini($localConfigFile, APPLICATION_ENVIRONMENT);
            self::$_config->merge($localConfig);
		}
		 */
	}

	/**
     * Initialise la configuration
     *
     * @return  Zend_Config_Ini
     */
    public static function setConfig ($file)
    {
        if (null === self::$_config) {
            Koala_Core_Init::initZendLoader();
            if (Zend_Loader::isReadable($file)) {
                self::$_config = new Zend_Config_Ini($file, APPLICATION_ENV, array('allowModifications' => true));
                self::_mergeWithLocal();
                self::_doDefines();
                self::$_isInit = true;
            }
        }
        return self::$_config;
    }


}
