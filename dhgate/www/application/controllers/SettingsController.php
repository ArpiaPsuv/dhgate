<?php
class SettingsController extends Zend_Controller_Action {
	public function init()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
	}
	public function indexAction() {
		
	}
	
	public function valuteAction()
	{
		$settings = new Settings();
		$this->view->valutes = $settings->getValute();
		if($this->_request->isPost())
		{
			$settings->update($_POST, 'id = 1');
		}
	}
}