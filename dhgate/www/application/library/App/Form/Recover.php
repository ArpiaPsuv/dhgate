<?php
class App_Form_Recover extends App_Form {

	public function init(){
		parent::init();
		/*$helper  = new Zend_View_Helper_Url();*/
		$this->setAction('/user/recover/');
		$this->setMethod('POST');

		$mail = new Zend_Form_Element_Text('mail', array(
		'required'=> true,
		'label'=>'E-mail Address :',
		'maxlength' => '80',
		'validators'=> array('EmailAddress', 'NotEmpty')
		));
		$this->addElement($mail);


		$submit = new Zend_Form_Element_Submit('submit', array(
        'label'=> 'Recover',
		));
		$this->addElement($submit);



		/* foreach($this->getElements() as $element){
		 $element->clearDecorators()
		 ->addDecorator("ViewHelper")
		 ->addDecorator("Errors");
		 }*/
	}
}