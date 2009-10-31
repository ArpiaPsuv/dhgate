<?php
class OrderController extends Zend_Controller_Action
{

	public function indexAction()
	{
		$num = (int)$this->_getParam('num',0);
		$order = new Order();
		$this->view->products = $products  = $order->getOrderByNum($num);
		$products = $products->toArray();
		$firstProduct = $products[0];
		$shipping = new Shipping();
		$this->view->shipping = $shipping->get($firstProduct['shipping']);
		$this->view->payment = $firstProduct['payment'];
		$this->view->firstProduct = $firstProduct;
		if($firstProduct['adress']){
			$adress = new Adress();
			$adress = $adress->find($firstProduct['adress'])->current();
			$this->view->adress = $adress;
		}
		$user = new User();
		$user = $user->find($firstProduct['user_id'])->current();
		$this->view->user = $user;
	}

	public function loginAction()
	{
		$country = new Country();
		$this->view->countrys = $country->fetchAll();
	}

	public function listAction()
	{
		$order = new Order();
		$status = $this->_getParam('status','new');
		$this->view->orders = $order->getOrders($status);
	}
	public function step1Action()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/order/login/');
		}
		$cart  = new Cart();
		if(Zend_Auth::getInstance()->hasIdentity()){
			$this->view->products = $cart->getProducts(Zend_Auth::getInstance()->getIdentity()->id);
		} else {
			$this->view->products = $cart->getProducts();
		}
		$user = $this->view->user = Zend_Auth::getInstance()->getIdentity();
		$country = new Country();
		$this->view->country =  $country->getCountry($user->country);
		$state = new State();
		$this->view->state = $state->getState($user->state);
		$adress = new Adress();
		$this->view->adreses = $adress->fetchAll('user_id = ' . Zend_Auth::getInstance()->getIdentity()->id);
	}

	public function step2Action()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/order/login/');
		}
		$cart  = new Cart();
		if(Zend_Auth::getInstance()->hasIdentity()){
			$this->view->products = $cart->getProducts(Zend_Auth::getInstance()->getIdentity()->id);
		} else {
			$this->view->products = $cart->getProducts();
		}
		$shipping = new Shipping();
		$this->view->shippings = $shipping->fetchAll();
		$user = $this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	public function step3Action()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/order/login/');
		}
		$cart  = new Cart();
		if(Zend_Auth::getInstance()->hasIdentity()){
			$this->view->products = $cart->getProducts(Zend_Auth::getInstance()->getIdentity()->id);
		} else {
			$this->view->products = $cart->getProducts();
		}
	}

	public function step4Action()
	{

	}
	public function completeAction()
	{

	}
	public function cartAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		foreach($_POST as $key=>$value){
			$_SESSION[$key] = $value;
		}
	}
	public function confirmAction()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/order/login/');
		}
		$cart  = new Cart();
		if(Zend_Auth::getInstance()->hasIdentity()){
			$this->view->products = $cart->getProducts(Zend_Auth::getInstance()->getIdentity()->id);
		} else {
			$this->view->products = $cart->getProducts();
		}

		// getting adress
		if(key_exists('adres', $_SESSION)){
			if($_SESSION['adres'] !=0){
				$adress = new Adress();
				$this->view->adress = $adress->find($_SESSION['adres'])->current();
			}
		} else {
			$_SESSION['adres'] = 'bank';
		}
		if(key_exists('shipping', $_SESSION)){
			if($_SESSION['shipping'] != 0){
				$shipping  = new Shipping();
				$this->view->shipping = $shipping->find($_SESSION['shipping'])->current();
			} else {
				$shipping = new Shipping();
				$shipping = $shipping->fetchAll();

				$this->view->shipping = $shipping[0];
				$_SESSION['shipping'] = 0;
			}
		} else {
			$shipping = new Shipping();
			$shipping = $shipping->fetchAll();

			$this->view->shipping = $shipping[0];
			$_SESSION['shipping'] = 0;
		}

		//getting payment method
		if(key_exists('card', $_SESSION)){
			$this->view->payment = $_SESSION['card'];
		} else {
			$this->view->payment = 'bank';
			$_SESSION['card']=0;
		}
	}

	public function createAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$cartTable = new Cart();
		$carts = $cartTable->getCart(Zend_Auth::getInstance()->getIdentity()->id);
		$order = new Order();
		Zend_Debug::dump($_SESSION);
		$num = $order->getMaxNum();
		$num++;
		$_SESSION['num']=$num;
		$date = new Zend_Date();
		foreach($carts as $cart){
			$cartTable->setInActive($cart->id);
			$order->insert(array(
				'shipping'=>$_SESSION['shipping'],
				'card_name' => $_SESSION['cardName'],
				'card_number' => $_SESSION['cardNumber'],
				'payment'  => $_SESSION['card'],
				'adress'   => $_SESSION['adres'],
				'cart_id'  => $cart->id,
				'user_id' => Zend_Auth::getInstance()->getIdentity()->id,
				'comment' =>$_POST['comment'],
				'num'=> $num,
				'status' => 'new', 
				'date' => $date->getIso()
			));
		}
	}

	public function updatestatusAction()
	{
		$status = $this->_getParam('status','new');
		$num = $this->_getParam('num',0);
		$order = new Order();
		$order->updateOrderStatus($num, $status);
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function trackAction()
	{
		if($this->_request->isPost())
		{
			$order = new Order();
			$this->view->status = $order->getTrack($_POST['number'], $_POST['mail']);
		}
	}
}