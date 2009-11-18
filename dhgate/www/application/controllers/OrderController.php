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
		$adress = new Adress();
		$this->view->adresses = $adress->fetchAll('user_id = ' . Zend_Auth::getInstance()->getIdentity()->id);
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect('/');
		}
		$form = new App_Form_Address();
		$this->view->form = $form;
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
		$order= new Order();
		
		
		
		if($this->_request->isPOST()){
			
			if ($_SESSION['admin']) {
				$_POST['coef']=str_replace('.',',',$_POST['coef']);
				if ($form->isValid($_POST)) {
					$_POST['coef']=str_replace(',','.',$_POST['coef']);              
	                $uploadedData = $form->getValues();
	               
	                $data=array(
	                'title'=> $_POST['title'],
	                'about'=>$_POST['about'],
	                'coef'=>$_POST['coef'],
	                'image'=>$uploadedData['image']
	                );
	                
	                $order->getAdapter()->insert('shipping_method',$data);
	                
	            
				 }

			}
		}
		
		$this->view->methods=$methods= $order->getShippingMethods();
	
		//Zend_Debug::dump($_SESSION);
	}
	
	public function step3Action() {
		
		$order= new Order();
		$select = $order->getAdapter()->select()
		->from('shipping_method')->
		where("id = ?" , $_SESSION['shipping']);
		$this->view->method=$shipping_method= $order->getAdapter()->fetchRow($select);
		
		
		$cart= Cart::create();
		$products = $this->view->products = $cart->getProducts();
		$sub_price=0;
		foreach ($products as $product) {
			$sub_price+=$product['price']*$product['count'];
		}
		
		$this->view->subprice=$sub_price;
		
		
		$address = new Adress();
		
		$shipping_address=$address->get(1);
		$billing_address =$address->get();
		if (!count($billing_address)) {
			$billing_address=$shipping_address;
		}
		
		

		
		$this->view->bill_address=$billing_address;
		$this->view->ship_address=$shipping_address;
		
		
		$confirm = $this->_getParam('confirm',0);
		if($confirm){
			$order->confirm();
			$this->_redirect('/order/step4/');
		}
				
	}
	
	
	public function paymentdeleteAction() 
	{
		if($_SESSION['admin']){
			$id= $this->_getParam('id',0);

			if($id>0){
			$order= new Order();	
			$order->getAdapter()->delete('payment_method',"id = $id");
			}
		}
		$this->_redirect('/order/step4/');
	}
	
	public function shippingdeleteAction() 
	{
		if($_SESSION['admin']){
			$id= $this->_getParam('id',0);

			if($id>0){
			$order= new Order();	
			$order->getAdapter()->delete('shipping_method',"id = $id");
			}
		}
		$this->_redirect('/order/step2/');
	}
	
	public function step4Action()
	{
		$this->view->form=$form=new App_Form_PaymentMethod();
		$order= new Order();
		
		if($this->_request->isPOST()){
			
			if ($_SESSION['admin']) {
				
				if ($form->isValid($_POST)) {
					       
	                $uploadedData = $form->getValues();
	               
	                $data=array(
	                'title'=> $_POST['title'],
	                'about'=>$_POST['about'],
	                'image'=>$uploadedData['image']
	                );
	                
	                $order->getAdapter()->insert('payment_method',$data);
	                
	            
				 }

			}
		}
		
		

		$this->view->payments=$payments= $order->getPaymentMethods();
		
		
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