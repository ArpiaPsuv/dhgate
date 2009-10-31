<?php
class MainController extends Zend_Controller_Action
{
	public $auth;
	public $admin;
	public function preDispatch()
	{
		$this->view->params  = $this->_getAllParams();
		$this->auth = Zend_Auth::getInstance();
		if ($this->auth->hasIdentity()){
			$this->admin = $this->auth->getIdentity()->admin;
			$_SESSION['admin'] = $this->admin;
		}

	}
	public function indexAction()
	{

	}
}