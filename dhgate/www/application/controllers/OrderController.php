<?php
class OrderController extends Zend_Controller_Action
{
	public function step1Action()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/');
		}
		$adress = new Adress();
		$this->view->adresses = $adress->fetchAll('user_id = ' . Zend_Auth::getInstance()->getIdentity()->id);
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/');
		}
		$form = new App_Form_Address();
		$this->view->form = $form;
	}
	
	public function setaddressAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$order = new Order();
		$order->setAddress((int) $this->_getParam('id', '0'));
		Zend_Debug::dump($_SESSION);
	}
	
	public  function step2Action()
	{
		
	}
}