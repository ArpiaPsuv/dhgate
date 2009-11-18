<?php
Class App_Form_User extends App_Form {

	Public function init() {
		parent::init();
		$this->setAction('/user/edit/');
		$this->setMethod('POST');

		$login=  new Zend_Form_Element_Text('login', array(
		'label'=>'Nickname: ',
		'required' => true,
		'maxlength' => '30',
		'validators' => array(
		array('Alnum', true, array(true)),
		array('StringLength', true, array(0, 30),'NotEmpty')),
		'filters'=>array('StringTrim','StripTags'),
        'filters' => array('StringTrim'), 
		));
		//$login->addValidator('NoDbRecordExists', true, array('user', 'login'));

		$pass = new Zend_Form_Element_Password('pass',array(
		'label'=>'New password: ',
		'maxlength' => '30',
		'filters'=>array('StringTrim','StripTags'),
		'validators' => array('Password',
		array('EqualInputs', true, array('pass_approve'))),
		));

		$passApprove=new Zend_Form_Element_Password('pass_approve',array(
		'label'=>'Password approve: ',
		'maxlength' => '30',
		'filters'=>array('StringTrim','StripTags'),
		'validators' => array(array('EqualInputs', true, array('pass'))),
		));


		$mail=new Zend_Form_Element_Text('mail',array(
		'required'=> true,
		'label'=>'E-mail Address: ',
		'maxlength' => '80',
		'filters'=>array('StringTrim','StripTags'),
		'validators'=> array('EmailAddress', 'NotEmpty')
		));
		//$mail->addValidator('NoDbRecordExists', true, array('user', 'mail'));
		///пока так

		$submit= new Zend_Form_Element_Submit('submit',array(
		'label'=>'Save'));


//		$firstname=  new Zend_Form_Element_Text('firstname', array(
//		'label'=>'Firstname: ',
//		'maxlength' => '30',
//		'validators' => array(
//		array('Alnum', true, array(true)),
//		array('StringLength', true, array(0, 30))),
//        'filters'=>array('StringTrim','StripTags'),
//		));
//
//		$middlename=  new Zend_Form_Element_Text('middlename', array(
//		'label'=>'Middlename: ',
//		'maxlength' => '30',
//		'validators' => array(
//		array('Alnum', true, array(true)),
//		array('StringLength', true, array(0, 30))),
//        'filters' => array('StringTrim'), 
//		));
//
//		$lastname=  new Zend_Form_Element_Text('lastname', array(
//		'label'=>'Lastname: ',
//		'maxlength' => '30',
//		'validators' => array(
//		array('Alnum', true, array(true)),
//		array('StringLength', true, array(0, 30))),
//        'filters' => array('StringTrim'), 
//		));
		//firstname	middlename	lastname


		$this->addElements(array(
		$mail,
		$login,
	//  $firstname,
	//	$middlename,
	//	$lastname,
		$pass,
		$passApprove,
		$submit

		));

	}


}