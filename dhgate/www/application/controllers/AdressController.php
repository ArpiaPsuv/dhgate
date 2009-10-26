<?php
class AdressController extends Zend_Controller_Action {
	public function indexAction() {
		$user_id = (int) $this->_getParam('user_id',0);
		$user = new User();
		$this->view->user = $user->find($user_id)->current();
		$adress = new Adress();
		$this->view->adreses = $adress->fetchAll('user_id = ' . $user_id);

	}
	public function addAction()
	{
		$country = new Country();
		$this->view->user_id = $this->_getParam('user_id',0);
		$this->view->countrys = $country->fetchAll();
		if($this->_request->isPost()){
			$adress = new Adress();
			if($_POST['nickname'] !=''
			&& $_POST['firstname'] != ''
			&& $_POST['adress'] != ''
			&& $_POST['city'] != ''
			&& $_POST['zip'] != ''
			&& $_POST['country'] != ''
			&& $_POST['state'] != ''
			&& $_POST['phone'] != '')
			{
				 
				$adress->add(Zend_Auth::getInstance()->getIdentity()->id, $_POST);
				if($this->_getParam('user_id',0)){
					$this->_redirect('/adress/index/user_id/' . $this->_getParam('user_id',0));
				} else {
					$this->_redirect('/order/step1/');
				}
			} else {
				$this->view->message = 'Error : Empty fields';
			}
		}
	}

	public function editAction()
	{
		$id = (int) $this->_getParam('id',0);
		$adress = new Adress();
		$adressRow = $this->view->adress = $adress->find($id)->current();
		$country = new Country();
		$this->view->countrys = $country->fetchAll();
		$state = new State();
		$this->view->states = $state->fetchAll('country_id=' . $adressRow->country);
		$this->view->user_id = (int) $this->_getParam('user_id',0);
		if($this->_request->isPost()){
			 
			if($_POST['nickname'] !=''
			&& $_POST['firstname'] != ''
			&& $_POST['adress'] != ''
			&& $_POST['city'] != ''
			&& $_POST['zip'] != ''
			&& $_POST['country'] != ''
			&& $_POST['state'] != ''
			&& $_POST['phone'] != '')
			{
				$adress->add(Zend_Auth::getInstance()->getIdentity()->id, $_POST, $id);
				if($this->_getParam('user_id',0)){
					$this->_redirect('/adress/index/user_id/' . $this->_getParam('user_id',0));
				} else {
					$this->_redirect('/order/step1/');
				}
			} else {
				$this->view->message = 'Error : Empty fields';
			}
		}
	}

	public function deleteAction()
	{
		$id = (int) $this->_getParam('id',0);
		$adress = new Adress();
		$adress->delete('id=' . $id);
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function setAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$_SESSION['adres'] = $this->_getParam('val',0);
		$user = new User();
		$user_id = (int) $this->_getParam('user_id',0);
		$user->update(array('current_adress'=>$this->_getParam('val',0)), 'id = ' . $user_id);
	}
}