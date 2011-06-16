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
				$namesite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('pathsite'); 
			} else {
				return array('error'=>true, 'message'=>$this->error ( 'Le chemin du site sur le serveur est ind&eacute;fini.'));
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('urlsite') ){
				$namesite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('urlsite'); 
			} else {
				return array('error'=>true, 'message'=>$this->error ( 'L\'url du site est ind&eacute;fini.'));
			}
		}
	}

	public function error ($error){
		return $error;
	}
}
