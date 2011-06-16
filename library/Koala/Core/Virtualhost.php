<?php
class Koala_Core_Virtualhost {
	
	public function getVirtualhost ( $data=array('ip'=>'*', 'port'=>'80', 'serveradmin'=>null, 'documentroot'=>'', 'servername'=>'', 'serveralias'=>'', 'directives'=>'') ){
				
		$vh  = "<VirtualHost ".$ip.":".$port.">\n";
		if ( null !== $data['serveradmin'] ){
			$vh .= "	ServerAdmin ";
		}
		$vh .= "	DocumentRoot \"".$data['documentroot']."\" \n";
		$vh .= "	ServerName ".$data['servername'] . "\n";
		$vh .= "	ServerAlias " . $data['serveralias'] . "\n";
		$vh .= $data['directives'];
		$vh .= "</VirtualHost>\n"; 
		return array('error'=>0, 'message'=>'VirtualHost g&eacute;n&eacute;r&eacute; avec succ&egrave;s.');
	}

	public function controleData ( $data ){
		if ( !is_array($data) ){
			return array('error'=>1, 'message'=>'Donn&eacute; incorrect pour la g&eacute;n&eacute;ration du virtualhost', 'virtualhost'=>'');
		}
		
	}
}
