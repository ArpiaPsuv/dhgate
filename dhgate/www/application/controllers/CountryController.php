<?php
class CountryController extends Zend_Controller_Action {
	public function indexAction()
	{
		$id = (int) $this->_getParam('id',0);
		$country = new Country();
		$countryRow = $country->find($id)->current();
		$this->view->country = $countryRow;
		$state = new State();
		$this->view->states = $state->fetchAll('country_id = ' . $countryRow->id);
	}

	public function addAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		$country = new Country();
		$this->view->countrys = $country->fetchAll();
		if($this->_request->isPost())
		{
			$country->insert($_POST);
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function deleteAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		$id = (int) $this->_getParam('id',0);
		$country = new Country();
		$countryRow = $country->find($id)->current();
		$countryRow->delete();
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function addstateAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		if($this->_request->isPost()){
			$state = new State();
			$state->insert($_POST);
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function deletestateAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		$state = new State();
		$id = (int) $this->_getParam('id',0);
		$state->delete('id = ' . $id);
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function getstateAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = (int) $this->_getParam('id',0);
		$state = new State();
		$this->view->states = $state->fetchAll('country_id = ' . $id);
	}

	public function allowedAction(){
		$country = new Country();
		$this->view->countrys = $country->fetchAll();
	}

	public function setallowedAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = (int)$this->_getParam('id',0);
		$country = new Country();
		$row = $country->find($id)->current();
		if($row->allowed){
			$country->update(array('allowed'=>0), 'id=' . $id);
		} else {
			$country->update(array('allowed'=>1), 'id=' . $id);
		}
	}

	public function isallowedAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = (int)$this->_getParam('id',0);
		$country = new Country();
		if($country->isAllowed($id)){
			$this->view->message = '';
		}  else {
			$this->view->message = 'This payment method not allowed for you country';
		}
	}
}