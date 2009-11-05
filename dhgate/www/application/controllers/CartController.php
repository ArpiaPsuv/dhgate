<?php
class CartController extends MainController
{
	public function indexAction()
	{// @todo сделать корзину пользователя
	$cart = new Cart();
	$products = $this->view->products = $cart->getProducts();
	$this->view->total_price=$cart->getTotalPrice();
	//Zend_Debug::dump($products);
	

	}
	public function testAction()
	{
	
		Zend_Layout::getMvcInstance()->disableLayout();

		
	$cart=new Cart();
//		Zend_Debug::dump($cart->getCart());
//		$id=85;
		
		//$cart->updateCount($id,10);
		//$cart->deleteProduct($id);
		 Zend_Debug::dump($cart->getCart());
		//$form=new App_Form_Regions();
 
	}
	public function addAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = (int)$this->_getParam('id',0);
		$cart = new Cart();
		if($id>0){
			$cart->addProduct($id,1);	
		}
		echo $cart->getCount();
	}

	public function deleteAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = $this->_getParam('id', 0);
		$cart = new Cart();
		$cart->deleteProduct($id);
		echo $cart->getCount();
	}
	
	public function updateAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = $this->_getParam('id', 0);
		$count=$this->_getParam('count', 0);
		$cart = new Cart();
		$cart->updateCount($id,$count);
		echo $cart->getCount();
	}
	
	public function clearAction()
	{
		$cart  = new Cart();
		$cart->clearCart();
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
	

}