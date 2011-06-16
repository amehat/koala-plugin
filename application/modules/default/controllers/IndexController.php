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
		$site->create();
	}

}
