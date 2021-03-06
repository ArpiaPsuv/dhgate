<?php

/**
 * AdminController
 *
 * @author
 * @version
 */

require_once 'Zend/Controller/Action.php';

class AdminController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function init()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}

	}
	public function indexAction()
	{
	//$valid= new Zend_Validate_Float();
		
//		if($valid->isValid('ewr')){
//			echo '1';
//		}else{
//			echo '0';
//		}
//		
//	
	   

	}
	
	public function valuteAction()
	{
		$valutes = new Valute();
		
		$delete = $this->_getParam('delete',0);
		$default= $this->_getParam('default',0);
		if($delete>0){
			$valutes->delete_valute($delete);
			$this->_redirect('/admin/valute/');
		}
		
		if($default>0){
			$valutes->setDefault($default);
			$this->_redirect('/admin/valute/');
		}
	
		if($this->_request->isPOST()){
			$float = new Zend_Validate_Float();
			$text=  new Zend_Filter_StringTrim();
			$_POST['prefix']=$text->filter($_POST['prefix']);
						
			if ($_POST['prefix']!='') {

				$aConventions = localeConv();
				$_POST['prefix'] = str_replace(',',$aConventions['decimal_point'], $_POST['prefix']);
				if($float->isValid($_POST['rate'])){
						$_POST['rate']=str_replace(',','.',$_POST['rate']);
						if($_POST['default']){
							$valutes->add($_POST['prefix'],$_POST['rate'],1);
						}else{
							$valutes->add($_POST['prefix'],$_POST['rate']);
					
					}
				}
			}
			$this->_redirect('/admin/valute/');
		}
		
		$this->view->valutes = $valutes->getValutes();
	}
	
	public function userlistAction()
	{
		$user = new User();
		$allUsers = $user->fetchAll();
		$this->view->users=$allUsers;

	}
	
	public function paymentsAction()
	{
		$this->view->form=$form=new App_Form_PaymentMethod();
		$payment= new Payment();
		
		$to_delete= $this->_getParam('delete',0);
		if ($to_delete>0){
			$payment->delete("id =$to_delete");
		}
		
		if($this->_request->isPOST()){
			
			if ($form->isValid($_POST)) {
					       
	                $uploadedData = $form->getValues();
	               
	                $data=array(
	                'title'=> $_POST['title'],
	                'about'=>$_POST['about'],
	                'image'=>$uploadedData['image']
	                );
	                
	                $payment->insert($data);
	                
	                 $this->_redirect('/admin/payments/');
	            
				 }
		}

		$this->view->payments=$payment->fetchAll();
	}	
		
	
	public function shippingAction()
	{
	
		$this->view->form=$form=new App_Form_ShippingMethod();
		$shipping= new Shipping();
		
		$to_delete= $this->_getParam('delete',0);
		if ($to_delete>0){
			$shipping->delete("id =$to_delete");
		}
		
		$this->view->shipping=$shipping->fetchAll();
		
		if($this->_request->isPOST()){
			
			
				$aConventions = localeConv();
				$_POST['coef'] = str_replace(',',$aConventions['decimal_point'], $_POST['coef']);
				if ($form->isValid($_POST)) {
					$_POST['coef']=str_replace(',','.',$_POST['coef']);              
	                $uploadedData = $form->getValues();
	               
	                $data=array(
	                'title'=> $_POST['title'],
	                'about'=>$_POST['about'],
	                'coef'=>$_POST['coef'],
	                'image'=>$uploadedData['image']
	                );
	                
	                $shipping->insert($data);
	                $this->_redirect('/admin/shipping/');
	           		}
	           		
		}
		
		
		
		
	}
	
	public function regionsAction()
	{
		$region= new Region();
		
		$form_add= new App_Form_AddRegion();
		if($this->_request->isPost()){
			
			$aConventions = localeConv();
				$_POST['coef'] = str_replace(',',$aConventions['decimal_point'], $_POST['coef']);
			if($form_add->isValid($this->_request->getPost())){
				$_POST['coef'] =str_replace(',','.',$_POST['coef']);
				$region->addRegion($_POST['name'],$_POST['coef']);
				$this->_redirect('/admin/regions/');
			}
		}
		$this->view->form=$form_add;		
		$this->view->regions=$region->getRegions();
		$to_delete= $this->_getParam('delete',0);
		if ($to_delete>0){
			$region->deleteRegion($to_delete);
		}
		
		
		
	}
	
	public function ordersAction()
	{
		$orders= new Order();
		$this->view->orders = $orders->getOrders();
	}
	
	public function orderAction() 
	{
		$id= $this->_getParam('id',0);
		$status= $this->_getParam('status',0);
		$orders = new Order();
		$users=  new User();
		$address = new Adress();
		$payment = new Payment();
		$shipping = new Shipping();
		$region = new Region();
		
		
		if($id >0){
			
			if($status){
				$orders->setStatus($id,$status);
				$this->_redirect('/admin/orders/');
			}
			
			$order= $orders->getOrder($id);
			$this->view->user = $user= $users->getUser($order['user_id']);
			$this->view->products = $orders->getProducts($id,$order['user_id']);

			$this->view->grand_total = $orders->getGrandTotal($id);
			
			$this->view->shipping_address=$address2 = $address->getAddres($order['address_shipping']);
			$this->view->billing_address=$address1 = $address->getAddres($order['address_billing']);
			
			$this->view->region1=$region->getRegion($address1['region']);
			$this->view->region2=$region->getRegion($address2['region']);
			
			$this->view->shipping = $shipping->get($order['shipping']);
			$this->view->payment = $payment->get($order['payment']);
		}
	}

	public function userdeleteAction()
	{
		$currentAdminID=Zend_Auth::getInstance()->getIdentity()->id;
		$id = (int)$this->_getParam('id',0);
		if (($id > 0) and ($id != $currentAdminID)) {
			$user = new User();
			$currentUser=$user->find($id)->current()->delete();
		}
		$this->_redirect("/admin/userlist");
	}

	public function userroleAction()
	{
		$currentAdminID=Zend_Auth::getInstance()->getIdentity()->id;
		$id = (int)$this->_getParam('id',0);
		if (($id > 0) and ($id != $currentAdminID)) {
			$user = new User();
			$currentUser=$user->find($id)->current();
			$currentUser->admin=(int)!$currentUser->admin;
			$currentUser->save();
		}
		$this->_redirect("/admin/userlist");
	}

}
?>
