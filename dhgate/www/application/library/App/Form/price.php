<?php
class App_Form_Price extends App_Form {

	public function init(){
		parent::init();
		/*$helper  = new Zend_View_Helper_Url();*/
		$this->setAction('/catalog/category/');
		$this->setMethod('POST');

	
		$from = new Zend_Form_Element_Text('from',array(
		
		'size'=>2
		));
		$this->addElement($from);
		$to = new Zend_Form_Element_Text('to',array(
		
		'size'=>2
		));
		$this->addElement($to);

		$submit = new Zend_Form_Element_Submit('go', array(
        'label'=> 'Go',
		));
		$this->addElement($submit);
		


		 foreach($this->getElements() as $element){
		 $element->clearDecorators()
		 ->addDecorator("ViewHelper")
		 ->addDecorator("Errors");
		 }
	}
}