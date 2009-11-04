<?php
class CartController extends MainController
{
	public function indexAction()
	{// @todo сделать корзину пользователя
	$cart = new Cart();
	$products = $this->view->products = $cart->getProducts();
	//Zend_Debug::dump($products);
	
	}
	public function testAction()
	{
	
		Zend_Layout::getMvcInstance()->disableLayout();


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

	public function updatecountAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$count = $this->_getParam('count', 0);
		if($this->_request->isPost())
		{
			$cart = new Cart();
			$cart->updateCount($_POST['product_id'], $count);
		}
	}
	
	public function clearAction()
	{
		$cart  = new Cart();
		$cart->clearCart();
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
	

}