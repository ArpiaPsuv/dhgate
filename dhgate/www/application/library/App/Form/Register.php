<?php
class App_Form_Register extends App_Form {

	public function init(){
		parent::init();
		/*$helper  = new Zend_View_Helper_Url();*/
		$this->setAction('/user/register/');
		$this->setMethod('POST');

		$mail = new Zend_Form_Element_Text('mail', array(
			'required'=> true,
			'validators'=> array('EmailAddress', 'NotEmpty'),
		'filters'=>array('StringTrim','StripTags'),
		));
		$mail->addValidator('NoDbRecordExists', true, array('user', 'mail'));
		$this->addElement($mail);

		$pass = new Zend_Form_Element_Password('pass', array(
			'required' => true,
			'maxlength' => '30',
			'validators' => array('Password'),
			'filters'=>array('StringTrim','StripTags'),
		));
		$this->addElement($pass);

		$passApprove = new Zend_Form_Element_Password('pass_approve', array(
		'required' => true,
		'maxlength' => '30',
		'validators' => array(array('EqualInputs', true, array('pass'))),
		'filters'=>array('StringTrim','StripTags'),
		));
		$this->addElement($passApprove);
			
		$login = new Zend_Form_Element_Text('login',
		array(
		'required' => true,
		'maxlength' => '30',
		'validators' => array(
		array('Alnum', true, array(true)),
		array('StringLength', true, array(0, 30),'NotEmpty')),
        'filters'=>array('StringTrim','StripTags'),
		));
		$login->addValidator('NoDbRecordExists', true, array('user', 'login'));
		$this->addElement($login);
			
		$submit = new Zend_Form_Element_Image('submit', array(
        	'src'=>'/application/public/img/create_my_account.gif'
        	));

        	$this->addElement($submit);


        	foreach($this->getElements() as $element){
        		$element->clearDecorators()
        		->addDecorator("ViewHelper")
        		->addDecorator("Errors");
        	}
	}
}