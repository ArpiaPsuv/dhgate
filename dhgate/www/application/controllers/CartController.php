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
		//$cart = new Cart();
		Zend_Layout::getMvcInstance()->disableLayout();
//		if(!isset($_COOKIE['session_id'])){
//			Zend_Session::rememberMe(3600*24*7);
//			setcookie("session_id", Zend_Session::getId(), time()+3600*24*7,'/'); 
//		}else{
//			if($_COOKIE['session_id'] != Zend_Session::getId()){
//				Zend_Session::rememberMe(3600*24*7);	
//				setcookie("session_id", Zend_Session::getId(), time()+3600*24*7,'/'); 
//			}
//		}
		
		//Zend_Session::rememberMe(30);
		//Zend_Session::rememberUntil(10);
		//session_set_cookie_params(60);
		//$q=	session_get_cookie_params();
		if(zend_session::isRegenerated()){
			echo "321";
		}else{
			echo "123";
		}
		//Zend_Debug::dump($q);

	}
	public function addAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		
		//$this->_redirect('/');
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
	public function getinfoAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
			
	}

}