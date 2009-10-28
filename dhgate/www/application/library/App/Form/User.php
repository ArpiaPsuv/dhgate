<?php 
Class App_Form_User extends App_Form {
	
	Public function init() {
		parent::init();
		$this->setAction('');
		$this->setMethod('POST');
		$login=  new Zend_Form_Element_Text('login');
		$newPassword = new Zend_Form_Element_Password('new_password');
		$newPasswordApprove=new Zend_Form_Element_Password('new_password_approve');
		$mail=new Zend_Form_Element_Text('mail');
		
		
		
		
		$this->addElements(array(
		
		
		
		));
		
	}
	
	
}