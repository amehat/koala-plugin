<?php
class Koala_Core_Site {
	
	public function create (){
		if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('createsite') ){
		
			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('namesite') ){
				$namesite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('namesite'); 
			} else {
				return array('error'=>true, 'message'=>$this->error ( 'Le nom du site est ind&eacute;fini.'));
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('pathsite') ){
				$pathsite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('pathsite'); 
			} else {
				return array('error'=>true, 'message'=>$this->error ( 'Le chemin du site sur le serveur est ind&eacute;fini.'));
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('urlsite') ){
				$urlsite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('urlsite'); 
				$servername = str_replace('http://', '', $urlsite);
				$servername = str_replace('ftp://', '', $urlsite);
			} else {
				return array('error'=>true, 'message'=>$this->error ( 'L\'url du site est ind&eacute;fini.'));
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('ip') ){
				$ip =  Zend_Controller_Front::getInstance()->getRequest()->getParam('ip');
			} else {
				$ip = '*';
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('port') ){
				$port =  Zend_Controller_Front::getInstance()->getRequest()->getParam('port');
			} else {
				$port = 80;
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('mailadmin') ){
				$serveradmin =  Zend_Controller_Front::getInstance()->getRequest()->getParam('mailadmin');
			} else {
				$serveradmin = null;
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('alias') ){
				$serveralias =  Zend_Controller_Front::getInstance()->getRequest()->getParam('alias');
			} else {
				$serveralias = '';
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('directives') ){
				$directives =  Zend_Controller_Front::getInstance()->getRequest()->getParam('directives');
			} else {
				$directives = '';
			}

			$Kvh = new Koala_Core_Virtualhost ();
			$aVirtualHost = array(
				'ip' => $ip,
				'port' => $port,
				'serveradmin' => $serveradmin,
				'documentroot' => $pathsite,
				'servername' => $servername, 
				'serveralias' => $serveralias,
				'directives' => $directives
			);
			$aVirtualhostData = $Kvh->getVirtualHost ( $aVirtualHost );
			if ( 1 == $aVirtualhostData['error'] ){
				return array('error'=>true, 'message'=>$this->error ( $aVirtualhostData['message'] ));
			} else {
				$sVirtualhost = $aVirtualhostData['virtualhost'];
			}
		}
	}

	public function error ($error){
		return $error;
	}
}
