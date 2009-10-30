<?php

class App_Form_Search extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		$this->setAction('/catalog/search/');
		$this->setMethod('POST');
		

		
		
		
		$category= new Zend_Form_Element_Select('category');
		$textSearch= new Zend_Form_Element_Text('text_search');
						 
		$go = new Zend_Form_Element_Submit('go');
		$go->setLabel('Go');
		

		$this->addElements(array(
		$textSearch,
		$category,
		$go
		));
		
		foreach($this->getElements() as $element){
			$element->clearDecorators()
			->addDecorator("ViewHelper")
			->addDecorator("Errors");
		}
	}
}