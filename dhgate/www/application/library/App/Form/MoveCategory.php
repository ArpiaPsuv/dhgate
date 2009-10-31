<?php

class App_Form_MoveCategory extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		$this->setAction('/catalog/move/');
		$this->setMethod('POST');



		$from=new Zend_Form_Element_Hidden('from');

		$to= new Zend_Form_Element_Select('to');

			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Move to');


		$this->addElements(array(
		$from,
		$submit,
		$to
		));

		foreach($this->getElements() as $element){
			$element->clearDecorators()
			->addDecorator("ViewHelper")
			->addDecorator("Errors");
		}
	}
}