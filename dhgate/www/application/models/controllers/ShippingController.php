<?php
class ShippingController extends Zend_Controller_Action {


	public function indexAction() {
		$shipping = new Shipping();
		$this->view->shippings = $shipping->fetchAll();
	}
	public function addAction()
	{
		if($this->_request->isPost()){
			$shipping  = new Shipping();
			$id = $shipping->insert($_POST);
			$image = new App_Image_Shipping($id);
			$image->upload($id);
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function editAction()
	{
		$id = (int) $this->_getParam('id',0);
		$shipping = new Shipping();
		$this->view->shipping = $shipping->find($id)->current();
		if($this->_request->isPost()){
			$shipping  = new Shipping();
			$shipping->update($_POST,'id =' . $id);
			$image = new App_Image_Shipping($id);
			$image->upload($id);
			$this->_redirect('/shipping/');
		}
	}

	public function deleteAction()
	{
		$id = (int) $this->_getParam('id',0);
		$shipping = new Shipping();
		$shipping->delete('id = ' . $id);
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function setAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$_SESSION['shipping'] = (int) $this->_getParam('val',0);
	}
}