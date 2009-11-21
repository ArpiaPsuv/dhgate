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
		
//		/////если заказ оформлен то не перенаправлять
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
				
				$last=array('last'=>0);
				$addres->update($last,'user_id = '.Zend_Auth::getInstance()->getIdentity()->id);
				
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
				
				//Zend_Debug::dump($data);
				$addres->addAddess($data);
				
				$this->_redirect('/order/step2/');
			//сохранить в базу	
			}	
			
		}else{
			$last = $addres->getLast();
			if(count($last)){
				if($last[0]['shipping']){
					$shipping=$last[0];
					$billing=$last[1];
				}else{
					$shipping=$last[1];
					$billing=$last[0];
				}
				
				$data=array(
				'company_b'=>$billing['company'],
				'contact_b'=>$billing['contact'],
				'address_b'=>$billing['address'],
				'address2_b'=>$billing['address2'],
				'city_b'=>$billing['city'],
				'region_b'=>$billing['region'],
				'state_b'=>$billing['state'],
				'postal_b'=>$billing['postal'],
				'phone_b'=>$billing['phone'],
				'fax_b'=>$billing['fax'],
				
				'company_s'=>$shipping['company'],
				'contact_s'=>$shipping['contact'],
				'address_s'=>$shipping['address'],
				'address2_s'=>$shipping['address2'],
				'city_s'=>$shipping['city'],
				'region_s'=>$shipping['region'],
				'state_s'=>$shipping['state'],
				'postal_s'=>$shipping['postal'],
				'phone_s'=>$shipping['phone'],
				'fax_s'=>$shipping['fax'],
								
				'shipping'=>0,
				);
				$form->populate($data);
			}
		}
		
		$this->view->form = $form;
		
		
		
		
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
		//Zend_Debug::dump($_SESSION);
		
		$address = new Adress();
		
		$shipping_address=$address->getAddres($_SESSION['shipping_address']);
		$billing_address =$address->getAddres($_SESSION['billing_address']);
	
		$region = new Region();
		$this->view->region1=$region->getRegion($billing_address['region']);
		$row=$this->view->region2=$region->getRegion($shipping_address['region']);
		
		$this->view->region_coef=$row['coef'];
		
		
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