<?php

class App_Form_Search extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		$this->setAction('/product/search/');
		$this->setMethod('POST');

		$category= new Zend_Form_Element_Select('category');
		$catalog = new Catalog();

		$category->addMultiOption(0,'All Categories');
		foreach($catalog->fetchAll() as $row)
		{
			$category->addMultiOption($row->id , $row->title);
		}

		$textSearch= new Zend_Form_Element_Text('text_search');
			
		$go = new Zend_Form_Element_Image('go', array('src'=>'/application/public/img/input_go_no_active.gif'));


		$this->addElements(array(
		$textSearch,
		$category,
		$go
		));

		foreach($this->getElements() as $element){
			$element->clearDecorators()
			->addDecorator("ViewHelper");
		}
	}
}