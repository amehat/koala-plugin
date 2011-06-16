<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function indexAction()
	{

	}

	public function loginAction (){}

	public function logoutAction (){}

	public function createsiteAction (){
		$site = new Koala_Core_Site ();
		$aSite = $site->create();
		$this->view->aSiteResult = $aSite;
		if ( true === $aSite['error']){
			
			if ('norequest' == $aSite['type'] ){
				$this->view->displayform = true;
				$this->view->displayerror = false;
			} 
			if ( 'datarequest' == $aSite['type'] ){
				$this->view->displayform = true;
				$this->view->displayerror = true;
			}
			if ( 'copy' == $aSite['type'] ){
				$this->view->displayform = true;
				$this->view->displayerror = true;
			}
		} else {
			$this->view->displayform = false;
		}
	}

}
