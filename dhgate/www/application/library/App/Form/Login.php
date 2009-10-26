<?php
class App_Form_Login extends App_Form {

	public function init(){
		parent::init();
		/*$helper  = new Zend_View_Helper_Url();*/
		$this->setAction('/user/login/');
		$this->setMethod('POST');

		$mail = new Zend_Form_Element_Text('mail', array(
		'required'=> true,
		'label'=>'E-mail Address :',
		'maxlength' => '80',
		'validators'=> array('EmailAddress', 'NotEmpty')
		));
		$this->addElement($mail);

		$pass = new Zend_Form_Element_Password('pass', array(
		'required' => true,
		'label'=>'Password :',
		'maxlength' => '30',
		'validators' => array('Password'),
		));
		$this->addElement($pass);
			
		$remember = new Zend_Form_Element_Checkbox('remember');
		$this->addElement($remember);

		$submit = new Zend_Form_Element_Submit('submit', array(
        'label'=> 'Sign in',
		));
		$this->addElement($submit);



		foreach($this->getElements() as $element){
			$element->clearDecorators()
			->addDecorator("ViewHelper")
			->addDecorator("Errors");
		}
	}
}