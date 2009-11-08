<?php
class AdressController extends Zend_Controller_Action {
	
	public function indexAction() {
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/');
		}
		$adress = new Adress();
		$this->view->adresses = $adress->fetchAll('user_id = ' . Zend_Auth::getInstance()->getIdentity()->id);
	}
	public function addAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		if(Zend_Auth::getInstance()->hasIdentity()){

		
		
		$form = new App_Form_Address();
		$this->view->form = $form;
			if($this->getRequest()->isPost()){
				if($form->isValid($this->getRequest()->getPost())){
					$adress = new Adress();
					$_POST['shipping'] = (int) $this->_getParam('shipping',0);
					unset($_POST['submit']);
					$_POST['user_id'] = Zend_Auth::getInstance()->getIdentity()->id;
					$result = $adress->get((int) $this->_getParam('shipping',0));
					if(count($result)){
						$adress->update($this->getRequest()->getPost(), 'id = ' . $result[0]['id']);
					} else {
						$adress->insert($this->getRequest()->getPost());
					}
				}
			}
		}
	}

	public function editAction()
	{
		$id = (int) $this->_getParam('id',0);
		$adress = new Adress();
		$row = $adress->find($id)->current();
		$form = new App_Form_Address();
		$form->setAction('/adress/edit/id/' . $id);
		$form->populate($row->toArray());
		$this->view->form = $form;
		if($this->getRequest()->isPost()){
			unset($_POST['submit']);
			if($form->isValid($this->getRequest()->getPost())){
				$adress->update($this->getRequest()->getPost(), 'id = ' . $id);
				$this->_redirect('/adress/');
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
}