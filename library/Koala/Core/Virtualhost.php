<?php
class Koala_Core_Virtualhost {
	
	public function getVirtualhost ( $data=array('ip'=>'*', 'port'=>'80', 'serveradmin'=>null, 'documentroot'=>'', 'servername'=>'', 'serveralias'=>'', 'directives'=>'') ){
		$c = $this->controleData($data);
		if ( 1 == $c['error'] )	{
			return array('error'=>true,'message'=>$c['message'], 'virtualhost'=>'');
		}
		$data = $c['data'];
		$vh  = "<VirtualHost ".$data['ip'].":".$data['port'].">\n";
		if ( null !== $data['serveradmin'] ){
			$vh .= "	ServerAdmin ";
		}
		$vh .= "	DocumentRoot \"".$data['documentroot']."\" \n";
		$vh .= "	ServerName ".$data['servername'] . "\n";
		if ( '' !== $data['serveralias'] ){
			$vh .= "	ServerAlias " . $data['serveralias'] . "\n";
		}
		if ( '' !== $data['directives'] ){
			$vh .= $data['directives'];
		}
		$vh .= "</VirtualHost>\n"; 
		return array('error'=>false, 'message'=>'VirtualHost g&eacute;n&eacute;r&eacute; avec succ&egrave;s.', 'virtualhost'=>$vh);
	}

	public function controleData ( $data ){
		if ( !is_array($data) ){
			return array('error'=>true, 'message'=>'Donn&eacute; incorrect pour la g&eacute;n&eacute;ration du virtualhost',  'data'=>$data);
		}
		
		if ( !array_key_exists('ip', $data) ){
			$data['ip'] = '*';
		}
		
		if ( !array_key_exists('port', $data) ){
			$data['port'] = '80';
		}
		
		if ( !array_key_exists('documentroot', $data) ){
			return array(
				'error'=>true,
				'message'=>'Le documentroot n\'est pas renseign&eacute;, impossible de g&eacute;n&eacute;rer le virtualhost.',
				'data' => $data
			);
		}
		if ( !array_key_exists('servername', $data) ){
			return array(
				'error'=>true,
				'message'=>'Le servername n\'est pas renseign&eacute;, impossible de g&eacute;n&eacute;rer le virtualhost.',
				'data' => $data
			);
		}
		
		if ( !array_key_exists('serveradmin', $data) ){
			$data['serveradmin'] = null;
		}
		
		if ( !array_key_exists('serveralias', $data) ){
			$data['serveralias'] = '';
		}
		
		if ( !array_key_exists('directives', $data) ){
			$data['directives'] = '';
		}
		
		return array(
			'error'=>false,
			'message'=>'',
			'data' => $data
		); 
	}
}
