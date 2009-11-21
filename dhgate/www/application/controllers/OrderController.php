<?php
class OrderController extends Zend_Controller_Action
{
	public function init() 
	{
		
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/user/login/');
		}
		$cart= Cart::create();
		$count = $cart->getcount();
		
		/////если заказ оформлен то не перенаправлять
//		if($count<1){
//			$this->_redirect('/cart/');
//		}
		
	}
	public function step1Action()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/');
		}
		
		
		$form = new App_Form_Address();
		$this->view->form = $form;
		$addres= new Adress();
		
		if($this->getRequest()->isPOST()){
			
			if($_POST['shipping']){
				$_POST['company_b']=$_POST['company_s'];
				$_POST['contact_b']=$_POST['contact_s'];
				$_POST['address_b']=$_POST['address_s'];
				$_POST['address2_b']=$_POST['address2_s'];
				$_POST['city_b']=$_POST['city_s'];
				$_POST['region_b']=$_POST['region_s'];
				$_POST['state_b']=$_POST['state_s'];
				$_POST['postal_b']=$_POST['postal_s'];
				$_POST['phone_b']=$_POST['phone_s'];
				$_POST['fax_b']=$_POST['fax_s'];
		
			}
			
			if($form->isValid($_POST)){
				
				$data=array(
				'company'=>$_POST['company_s'],
				'contact'=>$_POST['contact_s'],
				'address'=>$_POST['address_s'],
				'address2'=>$_POST['address2_s'],
				'city'=>$_POST['city_s'],
				'region'=>$_POST['region_s'],
				'state'=>$_POST['state_s'],
				'postal'=>$_POST['postal_s'],
				'phone'=>$_POST['phone_s'],
				'fax'=>$_POST['fax_s'],
				'shipping'=>1,
				'user_id'=>Zend_Auth::getInstance()->getIdentity()->id
				);
				
				$addres->addAddess($data, 1);
				
				$data=array(
				'company'=>$_POST['company_b'],
				'contact'=>$_POST['contact_b'],
				'address'=>$_POST['address_b'],
				'address2'=>$_POST['address2_b'],
				'city'=>$_POST['city_b'],
				'region'=>$_POST['region_b'],
				'state'=>$_POST['state_b'],
				'postal'=>$_POST['postal_b'],
				'phone'=>$_POST['phone_b'],
				'fax'=>$_POST['fax_b'],
				'shipping'=>0,
				'user_id'=>Zend_Auth::getInstance()->getIdentity()->id
				);
				
				$addres->addAddess($data);
				
				$this->_redirect('/order/step2/');
			//сохранить в базу	
			}	
			
		}
		$address = new Adress();
		
		
		$id_shipping=$this->_getParam('shipping',0);
		$id_billing=$this->_getParam('billing',0);
		
		
		if ($id_shipping > 0){
			$this->view->shipping=$shipping_address=$address->getAddres($id_shipping);
			if($id_billing>0){
				$this->view->billing=$address->getAddres($id_billing);
			}
			
		}
		
		
		
		
		
		//todo добавление адресов
		
	}
	
	public function setaddressAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$order = new Order();
		$order->setAddress((int) $this->_getParam('id', '0'));
		//Zend_Debug::dump($_SESSION);
	}
	
	public function setmethodAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$order = new Order();
		$order->setShippingMethod($this->_getParam('id',0));
	}
	
	public function setpaymentAction()
	{
 		Zend_Layout::getMvcInstance()->disableLayout();
		$payment_id= $this->_getParam('id',0);
		if ($payment_id>0) {
			$order = new Order();
			$order->setPaymentMethod($payment_id);
			$order->updatePayment();
		}
	
	}
	
	public  function step2Action()
	{
		$this->view->form=$form=new App_Form_ShippingMethod();
		$shipping= new Shipping();
		$this->view->methods=$methods= $shipping->fetchAll();
	}
	
	public function step3Action() {
		
		$order= new Order();
		$shipping = new Shipping();
	
		$this->view->method=$shipping->get($_SESSION['shipping']);
		
		
		$cart= Cart::create();
		$products = $this->view->products = $cart->getProducts();
		$sub_price=0;
		foreach ($products as $product) {
			$sub_price+=$product['price']*$product['count'];
		}
		
		$this->view->subprice=$sub_price;
		
		
		$address = new Adress();
		
		$shipping_address=$address->getAddres($_SESSION['shipping_address']);
		$billing_address =$address->getAddres($_SESSION['billing_address']);
	
		

		
		$this->view->bill_address=$billing_address;
		$this->view->ship_address=$shipping_address;
		
		
		$confirm = $this->_getParam('confirm',0);
		if($confirm){
			$order->confirm();
			$this->_redirect('/order/step4/');
		}
				
	}
	
	
	
	
	public function step4Action()
	{

		$payment= new Payment();
		$this->view->payments=$payment->fetchAll();
		
		
	}
	
	
	public function trackAction() 
	{
		
		if($this->getRequest()->isPOST()){
			$mail=$_POST['mail'];
			$number=$_POST['number'];
			
			$mailValid= new Zend_Validate_EmailAddress();
			$numberValid= new Zend_Validate_Digits();
		
			if($mailValid->isValid($mail) and $numberValid->isValid($number)){
				$order = new Order();
				$status =$order->track($mail,$number);	
				
				if ($status){
					$this->view->status=$status;
				}else{
					$this->view->status='error';
				}
					
						
			}
		}
	}
	
}