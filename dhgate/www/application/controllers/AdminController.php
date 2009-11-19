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
				$_POST['coef'] =str_replace('.',',',$_POST['coef']);
				
			if($form_add->isValid($this->_request->getPost())){
				$region->addRegion($_POST['name'],str_replace(',','.',$_POST['coef']));
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
