<?php
class Koala_Core_Site {
	
	public function create (){
		if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('createsite') ){
		
			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('namesite') ){
				$namesite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('namesite'); 
				$namesitedirectory = str_replace(' ', '', $namesite);
			} else {
				return array('error'=>true, 'type'=>'datarequest', 'message'=>$this->error ( 'Le nom du site est ind&eacute;fini.'));
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('pathsite') ){
				$pathsite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('pathsite'); 
			} else {
				return array('error'=>true, 'type'=>'datarequest', 'message'=>$this->error ( 'Le chemin du site sur le serveur est ind&eacute;fini.'));
			}

			if ( Zend_Controller_Front::getInstance()->getRequest()->getParam('urlsite') ){
				$urlsite =  Zend_Controller_Front::getInstance()->getRequest()->getParam('urlsite'); 
				$servername = str_replace('http://', '', $urlsite);
				$servername = str_replace('ftp://', '', $urlsite);
			} else {
				return array('error'=>true, 'type'=>'datarequest', 'message'=>$this->error ( 'L\'url du site est ind&eacute;fini.'));
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
				'documentroot' => $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory . DIRECTORY_SEPARATOR . 'public',
				'servername' => $servername, 
				'serveralias' => $serveralias,
				'directives' => $directives
			);
			$aVirtualhostData = $Kvh->getVirtualHost ( $aVirtualHost );
			if ( 1 == $aVirtualhostData['error'] ){
				return array('error'=>true, 'type'=>'datarequest', 'message'=>$this->error ( $aVirtualhostData['message'] ));
			} else {
				$sVirtualhost = $aVirtualhostData['virtualhost'];
			}
			
			if (( '' === $ip) || ('*' === $ip)){
				$iphost = '127.0.0.1';
			} else {
				$iphost = $ip;
			}
			$sHost = "$iphost	$servername\n";
			if ( '' !== $serveralias ){
				$sHost .= "$iphost	$serveralias\n";
			}
			if ( !file_exists($pathsite . DIRECTORY_SEPARATOR . $namesitedirectory . DIRECTORY_SEPARATOR) ){
				echo $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory . DIRECTORY_SEPARATOR . " n'existe pas <br />";
				if ( !mkdir($pathsite . DIRECTORY_SEPARATOR . $namesitedirectory) ){
					echo $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory . "est impossible a créé <br />.";
					$message = $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory . ' n\'est pas un repertoire valide'; // sinon on sort! Appel de fonction non valide
					return array(
						'error'=>true,
						'type' => 'copy',
						'message' => $message
					);
				} else {
					echo $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory . " a été créé avec succès. <br />";
					$result = $this->copy(ROOT_PATH . DIRECTORY_SEPARATOR . 'modelzf' . DIRECTORY_SEPARATOR, $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory );
				}
			} else {
				echo $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory . DIRECTORY_SEPARATOR . " existe <br />";
				$result = $this->copy(ROOT_PATH . DIRECTORY_SEPARATOR . 'modelzf' . DIRECTORY_SEPARATOR, $pathsite . DIRECTORY_SEPARATOR . $namesitedirectory );
			}
			if ( true == $result['error']){
				return $result;
			}
			
			return array('error'=>false, 'type'=>'request', 'message'=>'Votre site "'.$namesite.'" a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s', 'virtualhost'=>$sVirtualhost, 'host'=>$sHost);
		} else {
			return array('error'=>true, 'type'=>'norequest', 'message'=>'');
		}
	}
	
	private function copy ($source, $destination) {
		//echo 'lance la copie <br />';
		return Koala_Core_Utils_Copy::recursiveCopy ( $source, $destination );
	}

	public function error ($error){
		return $error;
	}
}
