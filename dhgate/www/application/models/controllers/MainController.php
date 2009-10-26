<?php
class MainController extends Zend_Controller_Action
{

	public function preDispatch()
	{
		$this->view->params  = $this->_getAllParams();
	}
	public function indexAction()
	{

	}
}