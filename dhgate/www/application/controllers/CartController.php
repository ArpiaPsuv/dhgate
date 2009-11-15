<?php
class CartController extends MainController
{
	public function indexAction()
	{
		$cart = Cart::create();
		$products = $this->view->products = $cart->getProducts();
		$totalPrice=0;
		foreach ($products as $product) {
			$totalPrice+=$product['price']*$product['count'];
		}
		$this->view->totalprice=$totalPrice;
	}

	public function addAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = (int)$this->_getParam('id',0);
		$count = (int) $this->_getParam('count',1);
		$cart = Cart::create();
		if($id>0){
			echo $cart->add($id,$count);
			echo $cart->getCount();
		}
	}

	public function deleteAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = $this->_getParam('id', 0);
		$cart = Cart::create();
		$cart->deleteProduct($id);
		echo $cart->getCount();
	}
	
	public function getcountAction() 
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$cart = Cart::create();
		echo $cart->getCount();
	}
	
	public function updateAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$id = $this->_getParam('id', 0);
		$count = $this->_getParam('count', 0);
		$cart = Cart::create();
		echo $cart->updateCount($id,$count,true);
	}
}