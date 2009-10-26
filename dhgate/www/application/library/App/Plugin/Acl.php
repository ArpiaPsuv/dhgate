<?php
class App_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
	function __construct()
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$user = $auth->getIdentity();
			if((boolean)$user->admin ){
				$_SESSION['admin'] = true;
			} else {
				$_SESSION['admin'] = false;
			}
		} else {
			$_SESSION['admin'] = false;
		}
		$_SESSION['admin'] = true;
	}
}
